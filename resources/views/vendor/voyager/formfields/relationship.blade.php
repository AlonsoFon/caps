@if (isset($options->model) && isset($options->type))

    @if (class_exists($options->model))

        @php $relationshipField = $row->field; @endphp

        @if ($options->type == 'belongsTo')

            @if (isset($view) && ($view == 'browse' || $view == 'read'))

                @php
                    $relationshipData = isset($data) ? $data : $dataTypeContent;
                    $model = app($options->model);
                    $query = $model::where($options->key, $relationshipData->{$options->column})->first();
                    if (isset($query)) {
                        $name_label = $query->{$options->label};
                    } else {
                        $name_label = __('voyager::generic.no_results');
                    }

                    if($model->slug == "estoques" && isset($query)){
                        $name_label = \DB::table('estoques')
                            ->join('produtos', 'estoques.produto_id', '=', 'produtos.id')
                            ->where('estoques.id', $query->{$options->key})
                            ->value('produtos.name');
                    }
                    if ($model instanceof \TCG\Voyager\Models\Role) {
                        $model->slug = 'roles';
                    }
                @endphp
                @if (isset($query))
                    @if (isset($model->slug))
                        <p><a
                                href="/admin/{{ $model->slug }}/{{ $query->{$options->key} }}">{{ $name_label }}</a>
                        </p>
                    @else
                        <p>{{ $name_label }}</p>
                    @endif
                @else
                    <p>{{ __('voyager::generic.no_results') }}</p>
                @endif
            @else
                <select class="form-control select2-ajax" name="{{ $options->column }}"
                    data-get-items-route="{{ route('voyager.' . $dataType->slug . '.relation') }}"
                    data-get-items-field="{{ $row->field }}"
                    @if (!is_null($dataTypeContent->getKey())) data-id="{{ $dataTypeContent->getKey() }}" @endif
                    data-method="{{ !is_null($dataTypeContent->getKey()) ? 'edit' : 'add' }}">
                    @php
                        $model = app($options->model);
                        $query = $model::where($options->key, $dataTypeContent->{$options->column})->get();
                        $name_default = __('voyager::generic.none');
                        $value_default = '';
                        if($model->slug == "users"){
                            $name_default = auth()->user()->name;
                            $value_default = auth()->user()->id;
                        }
                    @endphp

                    @if (!$row->required)
                        <option value="{{ $value_default }}">{{ $name_default }}</option>
                    @endif

                    @foreach ($query as $relationshipData)
                        @php
                        $name_label = $relationshipData->{$options->label};
                        if($model->slug == "estoques"){
                            $estoque = \App\Models\Estoque::with("produto")->where('estoques.id', $relationshipData->{$options->key})->first();
                            if(isset($estoque)){
                                $name_label = $estoque->produto->name . " - " . $estoque->lote . " (Disponível: " . $estoque->quantidade . ")";
                            }
                            
                        }
                        @endphp
                        <option value="{{ $relationshipData->{$options->key} }}"
                            @if ($dataTypeContent->{$options->column} == $relationshipData->{$options->key}) {{ 'selected="selected"' }} @endif>
                            {{ $name_label }}</option>
                    @endforeach
                </select>

            @endif
        @elseif($options->type == 'hasOne')
            @php

                $relationshipData = isset($data) ? $data : $dataTypeContent;

                $model = app($options->model);
                $query = $model::where($options->column, '=', $relationshipData->id)->first();

            @endphp

            @if (isset($query))
                @if (isset($model->slug))
                    <p><a
                            href="/admin/{{ $model->slug }}/{{ $query->{$options->key} }}">{{ $query->{$options->label} }}</a>
                    </p>
                @else
                    <p>{{ $query->{$options->label} }}</p>
                @endif
            @else
                <p>{{ __('voyager::generic.no_results') }}</p>
            @endif
        @elseif($options->type == 'hasMany')
            @if (isset($view) && ($view == 'browse' || $view == 'read'))

                @php
                    $relationshipData = isset($data) ? $data : $dataTypeContent;
                    $model = app($options->model);

                    $selected_values = $model
                        ::where($options->column, '=', $relationshipData->id)
                        ->get()
                        ->map(function ($item, $key) use ($options) {
                            return $item->{$options->label};
                        })
                        ->all();
                @endphp

                @if ($view == 'browse')
                    @php
                        $selected_keys = $model
                            ::where($options->column, '=', $relationshipData->id)
                            ->get()
                            ->map(function ($item, $key) use ($options) {
                                return $item->{$options->key};
                            })
                            ->all();
                    @endphp
                    @if (empty($selected_values))
                        <p>{{ __('voyager::generic.no_results') }}</p>
                    @else
                        <p>
                            @foreach ($selected_values as $index => $selected_value)
                                @php
                                    if ($index > 3) {
                                        echo '...';
                                        break;
                                    }
                                @endphp
                                @if ($index > 0)
                                    /
                                @endif
                                @if (isset($model->slug))
                                    <a
                                        href="/admin/{{ $model->slug }}/{{ $selected_keys[$index] }}">{{ $selected_value }}</a>
                                @else
                                    {{ $selected_value }}
                                @endif
                            @endforeach
                        </p>
                    @endif
                @else
                    @if (empty($selected_values))
                        <p>{{ __('voyager::generic.no_results') }}</p>
                    @else
                        <ul>
                            @php
                                $selected_keys = $model
                                    ::where($options->column, '=', $relationshipData->id)
                                    ->get()
                                    ->map(function ($item, $key) use ($options) {
                                        return $item->{$options->key};
                                    })
                                    ->all();

                            @endphp
                            @foreach ($selected_values as $index => $selected_value)
                                @if (isset($model->slug))
                                    <li><a
                                            href="/admin/{{ $model->slug }}/{{ $selected_keys[$index] }}">{{ $selected_value }}</a>
                                    </li>
                                @else
                                    <li>{{ $selected_value }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                @endif
            @else
                    <select class="form-control select2" name="{{ $options->column }}[]" multiple>
                        @php
                            $model = app($options->model);
                            $query = $model::get();
                        @endphp

                        @foreach ($query as $relationshipData)
                            <option value="{{ $relationshipData->{$options->key} }}" @if ($dataTypeContent->{$options->key} == $relationshipData->{$options->column} && !is_null($dataTypeContent->getKey())) {{ 'selected="selected"' }} @endif>
                                {{ $relationshipData->{$options->label} }}
                            </option>
                        @endforeach
                    </select>
            @endif
        @elseif($options->type == 'belongsToMany')
            @if (isset($view) && ($view == 'browse' || $view == 'read'))

                @php
                    $relationshipData = isset($data) ? $data : $dataTypeContent;

                    $selected_values = isset($relationshipData)
                        ? $relationshipData
                            ->belongsToMany($options->model, $options->pivot_table)
                            ->get()
                            ->map(function ($item, $key) use ($options) {
                                return $item->{$options->label};
                            })
                            ->all()
                        : [];
                @endphp

                @if ($view == 'browse')
                    @php
                        $string_values = implode(', ', $selected_values);
                        if (mb_strlen($string_values) > 60) {
                            $string_values = mb_substr($string_values, 0, 60) . '...';
                        }
                    @endphp
                    @if (empty($selected_values))
                        <p>{{ __('voyager::generic.no_results') }}</p>
                    @else
                        <p>{{ $string_values }}</p>
                    @endif
                @else
                    @if (empty($selected_values))
                        <p>{{ __('voyager::generic.no_results') }}</p>
                    @else
                        <ul>
                            @php
                                $model = app($options->model);
                                $selected_keys = isset($relationshipData)
                                    ? $relationshipData
                                        ->belongsToMany($options->model, $options->pivot_table)
                                        ->get()
                                        ->map(function ($item, $key) use ($options) {
                                            return $item->{$options->key};
                                        })
                                        ->all()
                                    : [];
                            @endphp
                            @foreach ($selected_values as $index => $selected_value)
                                @if (isset($model->slug))
                                    <li><a
                                            href="/admin/{{ $model->slug }}/{{ $selected_keys[$index] }}">{{ $selected_value }}</a>
                                    </li>
                                @else
                                    <li>{{ $selected_value }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                @endif
            @else
                <select
                    class="form-control @if (isset($options->taggable) && $options->taggable == 'on') select2-taggable @else select2-ajax @endif"
                    name="{{ $relationshipField }}[]" multiple
                    data-get-items-route="{{ route('voyager.' . $dataType->slug . '.relation') }}"
                    data-get-items-field="{{ $row->field }}"
                    @if (isset($options->taggable) && $options->taggable == 'on') data-route="{{ route('voyager.' . \Illuminate\Support\Str::slug($options->table) . '.store') }}"
                        data-label="{{ $options->label }}"
                        data-error-message="{{ __('voyager::bread.error_tagging') }}" @endif>

                    @php
                        $selected_values = isset($dataTypeContent)
                            ? $dataTypeContent
                                ->belongsToMany($options->model, $options->pivot_table)
                                ->get()
                                ->map(function ($item, $key) use ($options) {
                                    return $item->{$options->key};
                                })
                                ->all()
                            : [];
                        $relationshipOptions = app($options->model)->all();
                        $selected_values = old($relationshipField, $selected_values);
                    @endphp

                    @if (!$row->required)
                        <option value="">{{ __('voyager::generic.none') }}</option>
                    @endif

                    @foreach ($relationshipOptions as $relationshipOption)
                        <option value="{{ $relationshipOption->{$options->key} }}"
                            @if (in_array($relationshipOption->{$options->key}, $selected_values)) {{ 'selected="selected"' }} @endif>
                            {{ $relationshipOption->{$options->label} }}</option>
                    @endforeach

                </select>

            @endif

        @endif
    @else
        cannot make relationship because {{ $options->model }} does not exist.

    @endif

@endif
