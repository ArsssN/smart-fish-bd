<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{

    /**
     * @param $table
     * @return RedirectResponse
     */
    public function backupTable($table = null): RedirectResponse
    {
        $this->backupTableCmd($table);
        return redirect()->back();
    }

    /**
     * @param $table
     * @return string|void
     */
    public function backupTableCmd($table = null)
    {
        if (!$table) {
            // get files in folder
            $models = glob(app_path('Models/*.php'));
            $models = array_map('basename', $models);
            // get model names
            $models = array_map(
                function ($model) {
                    return str_replace('.php', '', $model);
                },
                $models
            );

            $exceptModels = [
                // 'User',
                'Setting',
                'RouteList'
            ];
            $models       = array_diff($models, $exceptModels);

            $defaultModels = [
                //'ModelHasRole'
            ];
            $models        = array_merge($defaultModels, $models);

            foreach ($models as $model) {
                //$model      = 'Cycle';
                $modelClass = "\App\Models\\$model";
                $costQuery  = (new $modelClass)::query();
                $table      = $costQuery->getModel()->getTable();
                $$table     = json_decode(DB::table($table)->get(), true);
                $this->writeData($table, $$table);
            }

            return count($models) . ' tables backed up';
        }

        $$table = json_decode(DB::table($table)->get(), true);
        $this->writeData($table, $$table);
    }

    /**
     * @param $table
     * @param $data
     * @return void
     */
    private function writeData($table, $data)
    {
        // write $$table in a file
        $file = fopen(database_path('seeders/seeder-data/') . $table . '.php', 'w');
        fwrite($file, '<?php' . PHP_EOL);
        fwrite($file, '$' . $table . ' = ' . var_export($data, true) . ';' . PHP_EOL);
        fwrite($file, 'return $' . $table . ';' . PHP_EOL);
        fclose($file);
    }
}
