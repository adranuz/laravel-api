<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class RoleUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        DB::table('roles_permissions')->delete();
        $this->call('db:seed', [
            '--class' => 'PermissionSeeder'
        ]);
        $permissions = DB::table('roles_permissions')->select('name', 'description')->get();
        $file_path = $path = app_path('Providers/AuthServiceProvider.php');

        if (file_exists($file_path)) {
            $file_string = file_get_contents($file_path);
            $inicio = strpos($file_string, "roles = [") + 9;
            $fin = strpos($file_string, "];//END");
            $cadena = substr($file_string, 0, $inicio);
            foreach ($permissions as $permission) {
                $cadena .= "'" . $permission->name . "' => '" . $permission->description . "',";
            }
            //$cadena .= "'alex' => 'asd'";
            $cadena .= substr($file_string, $fin);

            //dd($cadena, $inicio, $fin);
            file_put_contents($file_path, $cadena);
        }
    }
}
