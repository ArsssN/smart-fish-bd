<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\PermissionManager\app\Http\Requests\UserStoreCrudRequest as StoreRequest;
use Backpack\PermissionManager\app\Http\Requests\UserUpdateCrudRequest as UpdateRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        $singular = isShellAdminOrSuperAdmin()
            ? trans('backpack::permissionmanager.user')
            : 'Customer';
        $plural = isShellAdminOrSuperAdmin()
            ? trans('backpack::permissionmanager.users')
            : 'Customer';

        $this->crud->setModel(config('backpack.permissionmanager.models.user'));
        $this->crud->setEntityNameStrings($singular, $plural);
        $this->crud->setRoute(backpack_url('user'));

        // admin only can't access
        if (isCustomer()) {
            //CRUD::denyAccess(['list', 'create', 'delete', 'update', 'show', 'reorder']);
            CRUD::denyAccess(['create', 'delete', 'reorder']);
        }

        if (!backpack_auth()->user()->can('user.index')) {
            abort(403);
        }
    }

    public function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type' => 'text',
            ],
            [
                'name' => 'userDetails.account_holder_id',
                'label' => 'Account Holder ID',
            ],
            [
                'name' => 'userDetails.farm_name',
                'label' => 'Farm Name',
            ],
            [
                'name' => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type' => 'email',
            ],
            [
                'name' => 'userDetails.phone',
                'label' => 'Phone',
            ],
            /*[ // n-n relationship (with pivot table)
                'label' => trans('backpack::permissionmanager.roles'), // Table column heading
                'type' => 'select_multiple',
                'name' => 'roles', // the method that defines the relationship in your Model
                'entity' => 'roles', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => config('permission.models.role'), // foreign key model
            ],*/
            /*[ // n-n relationship (with pivot table)
                'label' => trans('backpack::permissionmanager.extra_permissions'), // Table column heading
                'type' => 'select_multiple',
                'name' => 'permissions', // the method that defines the relationship in your Model
                'entity' => 'permissions', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => config('permission.models.permission'), // foreign key model
            ],*/
        ]);

        if (backpack_pro() && isShellAdminOrSuperAdmin()) {
            $this->crud->addColumns([
                [ // n-n relationship (with pivot table)
                    'label' => trans('backpack::permissionmanager.roles'), // Table column heading
                    'type' => 'select_multiple',
                    'name' => 'roles', // the method that defines the relationship in your Model
                    'entity' => 'roles', // the method that defines the relationship in your Model
                    'attribute' => 'name', // foreign key attribute that is shown to user
                    'model' => config('permission.models.role'), // foreign key model
                ],
                [ // n-n relationship (with pivot table)
                    'label' => trans('backpack::permissionmanager.extra_permissions'), // Table column heading
                    'type' => 'select_multiple',
                    'name' => 'permissions', // the method that defines the relationship in your Model
                    'entity' => 'permissions', // the method that defines the relationship in your Model
                    'attribute' => 'name', // foreign key attribute that is shown to user
                    'model' => config('permission.models.permission'), // foreign key model
                ],
            ]);
            // Role Filter
            $this->crud->addFilter(
                [
                    'name' => 'role',
                    'type' => 'dropdown',
                    'label' => trans('backpack::permissionmanager.role'),
                ],
                config('permission.models.role')::all()->pluck('name', 'id')->toArray(),
                function ($value) { // if the filter is active
                    $this->crud->addClause('whereHas', 'roles', function ($query) use ($value) {
                        $query->where('role_id', '=', $value);
                    });
                }
            );

            // Extra Permission Filter
            $this->crud->addFilter(
                [
                    'name' => 'permissions',
                    'type' => 'select2',
                    'label' => trans('backpack::permissionmanager.extra_permissions'),
                ],
                config('permission.models.permission')::all()->pluck('name', 'id')->toArray(),
                function ($value) { // if the filter is active
                    $this->crud->addClause('whereHas', 'permissions', function ($query) use ($value) {
                        $query->where('permission_id', '=', $value);
                    });
                }
            );
        }

        $customerRole = Role::query()->where('name', ['Customer'])->first();

        // filter on name
        CRUD::filter('name')
            ->type('text')
            ->whenActive(function ($value) use ($customerRole) {
                $this->crud->addClause('where', 'name', 'like', "%$value%");
                $this->crud->addClause('orWhere', 'email', 'like', "%$value%");
                $this->crud->addClause('whereHas', 'roles', function ($query) use ($customerRole) {
                    $query->where('role_id', '=', $customerRole->id);
                });
            });

        // except ShellAdmin or SuperAdmin
        if (isOnlyAdmin()) {
            $this->crud->addClause('whereHas', 'roles', function ($query) use ($customerRole) {
                $query->where('role_id', '=', $customerRole->id);
            });
        }

        if (isCustomer()) {
            $this->crud->addClause('where', 'id', '=', backpack_user()->id);
        }
    }

    public function setupCreateOperation()
    {
        $this->addUserFields();
        $this->crud->setValidation(UserRequest::class);
    }

    public function setupUpdateOperation()
    {
        $this->addUserFields();
        $this->crud->setValidation(UserRequest::class);

        $entry = $this->crud->getCurrentEntry();
        if(isCustomer() && $entry->id != backpack_user()->id) {
            abort(403);
        }
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        // if password not set, generate a random password
        if (!$this->crud->getRequest()->input('password')) {
            $password = Str::random(8);

            $this->crud->getRequest()->request->set('password', $password);
            request()->request->set('password', $password);

            $this->crud->getRequest()->request->set('password_confirmation', $password);
            request()->request->set('password_confirmation', $password);
        }

        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        if (!isShellAdminOrSuperAdmin()) {
            $roles      = $this->crud->getRequest()->input('roles');
            $roles_show = $this->crud->getRequest()->input('roles_show');
            if ($roles == null || $roles == "[]") {
                $customerRole = Role::query()->where('name', 'Customer')->first();

                if ($customerRole) {
                    $roles = json_encode([$customerRole->id]);

                    $this->crud->getRequest()->request->set('roles', $roles);
                    request()->request->set('roles', $roles);

                    $this->crud->getRequest()->request->set('roles_show', $roles);
                    request()->request->set('roles_show', $roles);
                }
            } else {
                $roles = collect(json_decode($roles, true));
                if ($roles->count() > 0) {
                    $rolesId = $roles->pluck('id')->toArray();
                    $this->crud->getRequest()->request->set('roles', json_encode($rolesId));
                    request()->request->set('roles', json_encode($rolesId));
                }
            }
        }

        return $this->traitStore();
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        if (!isShellAdminOrSuperAdmin()) {
            $roles      = $this->crud->getRequest()->input('roles');
            $roles_show = $this->crud->getRequest()->input('roles_show');
            if ($roles == null || $roles == "[]") {
                $customerRole = Role::query()->where('name', 'Customer')->first();

                if ($customerRole) {
                    $roles = json_encode([$customerRole->id]);

                    $this->crud->getRequest()->request->set('roles', $roles);
                    request()->request->set('roles', $roles);

                    $this->crud->getRequest()->request->set('roles_show', $roles);
                    request()->request->set('roles_show', $roles);
                }
            } else {
                $roles = collect(json_decode($roles, true));
                if ($roles->count() > 0) {
                    $rolesId = $roles->pluck('id')->toArray();
                    $this->crud->getRequest()->request->set('roles', json_encode($rolesId));
                    request()->request->set('roles', json_encode($rolesId));
                }
            }
        }

        return $this->traitUpdate();
    }

    /**
     * Handle password input fields.
     */
    protected function handlePasswordInput($request)
    {
        // Remove fields not present on the user.
        $request->request->remove('password_confirmation');
        $request->request->remove('roles_show');
        $request->request->remove('permissions_show');

        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', Hash::make($request->input('password')));
        } else {
            $request->request->remove('password');
        }

        return $request;
    }

    protected function addUserFields()
    {
        $this->crud->addFields([
            [
                'name' => 'userDetails.first_name',
                'label' => 'First Name',
                'type' => 'text',
                'tab' => 'Basic',
            ],
            [
                'name' => 'userDetails.last_name',
                'label' => 'Last Name',
                'type' => 'text',
                'tab' => 'Basic',
            ],
            [
                'name' => 'name',
                'type' => 'hidden',
                'tab' => 'Basic',
            ],
            [
                'name' => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type' => 'email',
                'tab' => 'Basic',
            ],
            [
                'name' => 'username',
                'label' => 'Username',
                'type' => 'text',
                'tab' => 'Basic',
            ],
            [
                'name' => 'password',
                'label' => trans('backpack::permissionmanager.password'),
                'type' => 'password',
                'tab' => 'Basic',
            ],
            [
                'name' => 'password_confirmation',
                'label' => trans('backpack::permissionmanager.password_confirmation'),
                'type' => 'password',
                'tab' => 'Basic',
            ],
        ]);
        $this->crud->addFields([
            [
                'name' => 'userDetails.phone',
                'label' => 'Phone',
                'type' => 'text',
                'tab' => 'Details',
            ],
            [
                'name' => 'userDetails.address',
                'label' => 'Address',
                'type' => 'text',
                'tab' => 'Details',
            ],
            [
                'name' => 'userDetails.photo',
                'label' => 'Photo',
                'type' => 'browse',
                'tab' => 'Details',
            ],
            [
                'name' => 'userDetails.farm_name',
                'label' => 'Farm Name',
                'tab' => 'Details',
            ],
            [
                'name' => 'userDetails.n_id_photos',
                'label' => 'NID Photos',
                'type' => 'browse_multiple',
                'multiple' => true, // enable/disable the multiple selection functionality
                'sortable' => true, // enable/disable the reordering with drag&drop
                'tab' => 'Details',
            ],
            [
                'name' => 'userDetails.account_holder_id',
                'label' => 'Account Holder ID',
                'tab' => 'Details',
            ],
        ]);

        if (isShellAdminOrSuperAdmin()) {
            $this->crud->addFields([
                [
                    // two interconnected entities
                    'label' => trans('backpack::permissionmanager.user_role_permission'),
                    'field_unique_name' => 'user_role_permission',
                    'type' => 'checklist_dependency',
                    'name' => ['roles', 'permissions'],
                    'subfields' => [
                        'primary' => [
                            'label' => trans('backpack::permissionmanager.roles'),
                            'name' => 'roles', // the method that defines the relationship in your Model
                            'entity' => 'roles', // the method that defines the relationship in your Model
                            'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                            'attribute' => 'name', // foreign key attribute that is shown to user
                            'model' => config('permission.models.role'), // foreign key model
                            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?]
                            'number_columns' => 3, //can be 1,2,3,4,6
                        ],
                        'secondary' => [
                            'label' => mb_ucfirst(trans('backpack::permissionmanager.permission_plural')),
                            'name' => 'permissions', // the method that defines the relationship in your Model
                            'entity' => 'permissions', // the method that defines the relationship in your Model
                            'entity_primary' => 'roles', // the method that defines the relationship in your Model
                            'attribute' => 'name', // foreign key attribute that is shown to user
                            'model' => config('permission.models.permission'), // foreign key model
                            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?]
                            'number_columns' => 3, //can be 1,2,3,4,6
                        ],
                    ],
                    'tab' => 'Roles & Permissions',
                ]
            ]);
        } else {
            $this->crud->addFields([
                [
                    'name'  => 'roles',
                    'label' => 'Roles',
                    'type'  => 'hidden',
                ],
                [
                    'name'  => 'permissions',
                    'label' => 'Permissions',
                    'type'  => 'hidden',
                ],
            ]);
        }
    }
}
