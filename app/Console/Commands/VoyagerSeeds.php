<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class VoyagerSeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:voyager-seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pega todos os dados salvos do Voyager e gera seeds';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {


        $tables = collect([
            "data_types","data_rows","menus","menu_items","settings"
        ]);


        $tables->each(function ($table) {
            //php artisan iseed {table} --force
            $t = \Artisan::call("iseed", [
                "tables" => $table,
                "--force" => true,
            ]);

            if ($t === 0) {
                $this->info(' - Created a seed file from table ' . $table);
            } else {
                $this->error(' -Error on Try to Create a seed file from table ' . $table);
            }
        });

    }
}
