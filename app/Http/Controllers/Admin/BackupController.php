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
     *
     * @return RedirectResponse
     */
    public function backupTable($table = null): RedirectResponse
    {
        $this->backupTableCmd($table);
        return redirect()->back();
    }

    /**
     * @param $table
     *
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
            $models = array_diff($models, $exceptModels);

            $defaultModels = [
                //'ModelHasRole'
            ];
            $models = array_merge($defaultModels, $models);

            foreach ($models as $model) {
                //$model      = 'Cycle';
                $modelClass = "\App\Models\\$model";
                $modelQuery = (new $modelClass)::query();
                $table = $modelQuery->getModel()->getTable();
                $$table = json_decode(DB::table($table)->get(), true);
                $this->writeData($table, $$table);
            }

            return count($models) . ' tables backed up';
        }

        $$table = json_decode(DB::table($table)->get(), true);
        $this->writeData($table, $$table);
    }

    /**
     * @return RedirectResponse
     */
    public function removeSeed()
    {
        if (!app()->environment('local')) {
            return 'Not in local environment';
        }

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
            'About',
            'User',
            'ContactUs',
            'UserDetail',
            'Setting',
            "FooterLink",
            "FooterLinkGroup",
            "ModelHasRole",
            'PasswordReset',
            'Role',
            'SwitchModel',
            'SwitchType',
            //'SwitchUnit',
            'Sensor',
            'SensorType',
            //'SensorUnit',
            'Social',
            'RouteList'
        ];
        $models = array_diff($models, $exceptModels);

        $defaultModels = [
            //'ModelHasRole'
        ];
        $models = array_merge($defaultModels, $models);

        foreach ($models as $model) {
            $modelClass = "\App\Models\\$model";
            $modelQuery = (new $modelClass)::query();
            $table = $modelQuery->getModel()->getTable();

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table($table)->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        return response()->json([
            'message' => count($models) . ' tables truncated',
            'data' => $models
        ]);
    }

    /**
     * @param $table
     * @param $data
     *
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
