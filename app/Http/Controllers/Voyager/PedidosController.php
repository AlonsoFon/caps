<?php

namespace App\Http\Controllers\Voyager;

use Carbon\Carbon;
use Validator;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class PedidosController extends VoyagerBaseController
{

    public function update(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Compatibility with Model binding.
        $id = $id instanceof \Illuminate\Database\Eloquent\Model ? $id->{$id->getKeyName()} : $id;

        $model = app($dataType->model_name);
        $query = $model->query();
        if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope'.ucfirst($dataType->scope))) {
            $query = $query->{$dataType->scope}();
        }
        if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
            $query = $query->withTrashed();
        }

        $data = $query->findOrFail($id);
        if($data->estoque->quantidade < $request->quantidade_entregue){
            return redirect()->back()->with([
                'message'    => "Esse lote não tem quantidade suciente para entregar. Quantidade disponível: {$data->estoque->quantidade}. Selecione outro lote ou altere a quantidade a ser entregue.",
                'alert-type' => 'error',
            ]);
        }


        // Check permission
        $this->authorize('edit', $data);

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id)->validate();

        // Get fields with images to remove before updating and make a copy of $data
        $to_remove = $dataType->editRows->where('type', 'image')
            ->filter(function ($item, $key) use ($request) {
                return $request->hasFile($item->field);
            });
        $original_data = clone($data);

        $this->insertUpdateData($request, $slug, $dataType->editRows, $data);
        if($request->status == 'Entregue'){
            $data->estoque->quantidade = $data->estoque->quantidade - $request->quantidade_entregue;
            $data->estoque->save();
        }

        // Delete Images
        $this->deleteBreadImages($original_data, $to_remove);

        event(new BreadDataUpdated($dataType, $data));

        if (auth()->user()->can('browse', app($dataType->model_name))) {
            $redirect = redirect()->route("voyager.{$dataType->slug}.index");
        } else {
            $redirect = redirect()->back();
        }

        return $redirect->with([
            'message'    => __('voyager::generic.successfully_updated')." {$dataType->getTranslatedAttribute('display_name_singular')}",
            'alert-type' => 'success',
        ]);
    }
    public function relation(Request $request)
    {
        $slug = $this->getSlug($request);
        $page = $request->input('page');
        $on_page = 50;
        $search = $request->input('search', false);
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $method = $request->input('method', 'add');

        $model = app($dataType->model_name);
        if ($method != 'add') {
            $model = $model->find($request->input('id'));
        }

        $this->authorize($method, $model);

        $rows = $dataType->{$method.'Rows'};
        foreach ($rows as $key => $row) {
            if ($row->field === $request->input('type')) {
                $options = $row->details;
                $model = app($options->model);
                $skip = $on_page * ($page - 1);

                $additional_attributes = $model->additional_attributes ?? [];
                $isEstoqueRelation = method_exists($model, 'getTable') && $model->getTable() === 'estoques';

                // Apply local scope if it is defined in the relationship-options
                if (isset($options->scope) && $options->scope != '' && method_exists($model, 'scope'.ucfirst($options->scope))) {
                    $model = $model->{$options->scope}();
                }

                // If search query, use LIKE to filter results depending on field label
                if ($search) {
                    if ($isEstoqueRelation) {
                        $relationshipOptionsQuery = $model->with('produto')
                            ->where('quantidade', '>', 0)
                            ->where(function ($query) use ($search) {
                                $query->where('lote', 'LIKE', '%'.$search.'%')
                                    ->orWhereHas('produto', function ($produtoQuery) use ($search) {
                                        $produtoQuery->where('name', 'LIKE', '%'.$search.'%');
                                    });
                            });

                        $total_count = (clone $relationshipOptionsQuery)->count();
                        $relationshipOptions = $relationshipOptionsQuery->take($on_page)->skip($skip)->get();
                    } else {
                    // If we are using additional_attribute as label
                    if (in_array($options->label, $additional_attributes)) {
                        $relationshipOptions = $model->get();
                        $relationshipOptions = $relationshipOptions->filter(function ($model) use ($search, $options) {
                            return stripos($model->{$options->label}, $search) !== false;
                        });
                        $total_count = $relationshipOptions->count();
                        $relationshipOptions = $relationshipOptions->forPage($page, $on_page);
                    } else {
                        $total_count = $model->where($options->label, 'LIKE', '%'.$search.'%')->count();
                        $relationshipOptions = $model->take($on_page)->skip($skip)
                            ->where($options->label, 'LIKE', '%'.$search.'%')
                            ->get();
                    }
                    }
                } else {
                    if ($isEstoqueRelation) {
                        $relationshipOptionsQuery = $model->with('produto')->where('quantidade', '>', 0);
                        $total_count = (clone $relationshipOptionsQuery)->count();
                        $relationshipOptions = $relationshipOptionsQuery->take($on_page)->skip($skip)->get();
                    } else {
                        $total_count = $model->count();
                        $relationshipOptions = $model->take($on_page)->skip($skip)->get();
                    }
                }

                $results = [];

                if (!$row->required && !$search && $page == 1) {
                    $results[] = [
                        'id'   => '',
                        'text' => __('voyager::generic.none'),
                    ];
                }

                // Sort results
                if (!empty($options->sort->field)) {
                    if (!empty($options->sort->direction) && strtolower($options->sort->direction) == 'desc') {
                        $relationshipOptions = $relationshipOptions->sortByDesc($options->sort->field);
                    } else {
                        $relationshipOptions = $relationshipOptions->sortBy($options->sort->field);
                    }
                }
                
                foreach ($relationshipOptions as $relationshipOption) {
                    $name_label = $relationshipOption->{$options->label};
                    $canBeOption = true;
                    if ($isEstoqueRelation) {
                        if (empty($relationshipOption->produto) || $relationshipOption->quantidade <= 0) {
                            $canBeOption = false;
                        } else {
                            $name_label = $relationshipOption->produto->name . ' - ' . $relationshipOption->lote . " (Disponível: " . $relationshipOption->quantidade . ")";
                        }
                    }
                    if($canBeOption){
                        $results[] = [
                            'id'   => $relationshipOption->{$options->key},
                            'text' => $name_label,
                        ];
                    }
                }

                return response()->json([
                    'results'    => $results,
                    'pagination' => [
                        'more' => ($total_count > ($skip + $on_page)),
                    ],
                ]);
            }
        }

        // No result found, return empty array
        return response()->json([], 404);
    }
}
