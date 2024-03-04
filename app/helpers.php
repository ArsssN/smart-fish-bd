<?php

use App\Models\Cycle;
use App\Models\EMI;
use App\Models\Role as AppRole;
use App\Models\User;
use Backpack\PermissionManager\app\Models\Permission;
use Backpack\PermissionManager\app\Models\Role;
use App\Models\Setting as BackpackSetting;
use App\Models\SiteSetting as SiteSetting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

if (!function_exists('cacheClear')) {
    /**
     * @param $key
     * @return void
     */
    function cacheClear($key)
    {
        if (Cache::has($key)) {
            Cache::forget($key);
        }
    }
}

if (!function_exists('cacheStore')) {
    /**
     * @param $key
     * @param $callable
     * @return mixed
     */
    function cacheStore($key, $callable)
    {
        return Cache::remember($key, now()->addDay(), $callable);
    }
}

if (!function_exists('getSettingValue')) {
    /**
     * @param $meta_slug
     * @return Builder|Model
     */
    function getSettingValue($meta_slug)
    {
        return Config::get("settings.{$meta_slug}");
    }
}

//if (!function_exists('defaultDateTimeFormat')) {
//    /**
//     * @return Builder|Model|object|string
//     */
//    function defaultDateTimeFormat()
//    {
//        return SiteSetting::query()->where('meta_slug', 'default_date_time_format')->first() ?? 'Y-m-d h:i:sA';
//    }
//}

//if (!function_exists('siteSettings')) {
//    /**
//     * @param $meta_slug
//     * @return Builder|Builder[]|Collection|Model
//     */
//    function siteSettings($meta_slug = null)
//    {
//        $siteSetting = SiteSetting::query();
//
//        if ($meta_slug) {
//            $siteSetting = $siteSetting->where('meta_slug', $meta_slug)->first();
//        } else {
//            $siteSetting = $siteSetting->get();
//            $siteSetting = $siteSetting->keyBy('meta_slug');
//        }
//
//        return $siteSetting;
//    }
//}
//
//if (!function_exists('getTopNavbars')) {
//    /**
//     * @return mixed
//     */
//    function getTopNavbars()
//    {
//        return cacheStore('top_navbars', fn() => TopNavbar::with(['category' => fn($query) => $query->select('id', 'name', 'slug')])->get(['id', 'category_id']));
//    }
//}

if (!function_exists('setPermissionsToRole')) {
    /**
     * @param $permissionIds
     * @param $roles
     * @return void
     */
    function setPermissionsToRoles($permissionIds, $roles)
    {
        foreach ($roles as $role) {
            $role = Role::query()->where('name', $role)->first();
            ("setPermissionsTo" . $role->name)($permissionIds, $role, false);
        }
    }
}

if (!function_exists('setPermissionsToSuperAdmin')) {
    /**
     * @param $permissionIds
     * @param Role $role
     * @return void
     */
    function setPermissionsToSuperAdmin($permissionIds, Role $role)
    {
        $permissionIds = mergePublicPermissions($permissionIds);
        $role->syncPermissions($permissionIds);
    }
}

if (!function_exists('setPermissionsToShellAdmin')) {
    /**
     * @param array $permissionIds
     * @param Role $role
     * @param array $accept
     * @param array $except
     * @param bool $manual
     * @return void
     */
    function setPermissionsToShellAdmin(array $permissionIds, Role $role, bool $manual = true, array $accept = [], array $except = [])
    {
        $guard_name        = config('backpack.base.guard') ?? 'web';
        $permissionBuilder = Permission::query();

        $except        = array_unique(array_merge($except, []));
        $exceptIDs     = $permissionBuilder->whereIn('name', $except)->pluck('id')->toArray();
        $permissionIds = array_diff($permissionIds, $exceptIDs);

        $acceptIDs     = $permissionBuilder->where('guard_name', $guard_name)
            ->whereIn('name', $accept)
            ->pluck('id')
            ->toArray();
        $permissionIds = array_unique(array_merge(
            $acceptIDs,
            $permissionIds
        ));
        $permissionIds = mergePublicPermissions($permissionIds);

        $role->syncPermissions($permissionIds);
    }
}

if (!function_exists('setPermissionsToAdmin')) {
    /**
     * @param array $permissionIds
     * @param Role $role
     * @param array $accept
     * @param array $except
     * @param bool $manual
     * @return void
     */
    function setPermissionsToAdmin(array $permissionIds, Role $role, bool $manual = true, array $accept = [], array $except = [])
    {
        $guard_name        = config('backpack.base.guard') ?? 'web';
        $permissionBuilder = Permission::query();

        $except        = array_unique(array_merge($except, [
            "permission.create",
            "permission.destroy",
            "permission.edit",
            "permission.index",
            "permission.search",
            "permission.showDetailsRow",
            "permission.store",
            "permission.update",
            "site-setting.create",
            "site-setting.destroy",
            "site-setting.edit",
            "site-setting.index",
            "site-setting.search",
            "site-setting.show",
            "site-setting.showDetailsRow",
            "site-setting.store",
            "site-setting.update",
            "role.create",
            "role.destroy",
            "role.edit",
            "role.index",
            "role.search",
            "role.showDetailsRow",
            "role.store",
            "role.update",
            "user.index",
            "user.search",
            "user.showDetailsRow",
            "user.create",
            "user.store",
            "user.edit",
            "user.update",
            "user.destroy",

            "route-list.index",
            "route-list.search",
            "route-list.showDetailsRow",
            "route-list.create",
            "route-list.store",
            "route-list.edit",
            "route-list.update",
            "route-list.destroy",
            "route-list.show",
        ]));
        $exceptIDs     = $permissionBuilder->whereIn('name', $except)->pluck('id')->toArray();
        $permissionIds = array_diff($permissionIds, $exceptIDs);

        $acceptIDs     = $permissionBuilder->where('guard_name', $guard_name)
            ->whereIn('name', $accept)
            ->pluck('id')
            ->toArray();
        $permissionIds = array_unique(array_merge(
            $acceptIDs,
            $permissionIds
        ));
        $permissionIds = mergePublicPermissions($permissionIds);

        $role->syncPermissions($permissionIds);
    }
}

if (!function_exists('setPermissionsToUser')) {
    /**
     * @param array $permissionIds
     * @param Role $role
     * @param array $accept
     * @param array $except
     * @param bool $manual
     * @return void
     */
    function setPermissionsToUser(array $permissionIds, Role $role, bool $manual = true, array $accept = [], array $except = [])
    {
        $permissionIds     = $manual
            ? $permissionIds
            : [];
        $guard_name        = config('backpack.base.guard') ?? 'web';
        $permissionBuilder = Permission::query()->where('guard_name', $guard_name);

        $except        = array_unique(array_merge(
            $except,
            $permissionBuilder->pluck('name')->toArray()
        ));
        $exceptIDs     = $permissionBuilder->whereIn('name', $except)->pluck('id')->toArray();
        $permissionIds = array_diff($permissionIds, $exceptIDs);

        $acceptIDs     = $permissionBuilder->where('guard_name', $guard_name)
            ->whereIn('name', $accept)
            ->pluck('id')
            ->toArray();
        $permissionIds = array_unique(array_merge(
            $acceptIDs,
            $permissionIds
        ));
        $permissionIds = mergePublicPermissions($permissionIds);

        $role->syncPermissions($permissionIds);
    }
}

if (!function_exists('getPublicPermissions')) {
    /**
     * @param string $type
     * @return string[]
     */
    function getPublicPermissions(string $type = 'name'): array
    {
        $publicPermissions = [
            "backpack",
            "backpack.dashboard",
            "backpack.account.info",
            "backpack.account.info.store",
            "backpack.account.password",
            "backpack.auth.password.email",
            "backpack.auth.password.reset.token",
            "backpack.auth.password.reset",
            "backpack.auth.logout",
            "backpack.auth.login",
        ];

        if ($type == 'id') {
            $publicPermissions = Permission::query()
                ->whereIn('name', $publicPermissions)
                ->pluck('id')
                ->toArray();
        }

        return $publicPermissions;
    }
}

if (!function_exists('mergePublicPermissions')) {
    /**
     * @param array $permissionIds
     * @return array
     */
    function mergePublicPermissions(array $permissionIds): array
    {
        $publicPermissionIds = getPublicPermissions('id');

        return array_unique(array_merge($permissionIds, $publicPermissionIds));
    }
}

if (!function_exists('getAllRoutesName')) {
    function getAllRoutesName(...$search)
    {
        $routesName = backpack_user()
            ->getAllPermissions()
            ->sortBy('name')
            ->pluck('name');

        return ($search
            ? $routesName->map(function ($name) use ($search) {
                foreach ($search as $src)
                    if (ifFoundPosition($name, $src))
                        return $name;
                return false;
            })->reject(function ($val) {
                return $val == false;
            })
            : $routesName)->values()->toArray();
    }
}

if (!function_exists('ifFoundPosition')) {
    function ifFoundPosition($name, $search): bool
    {
        return strpos($name, $search) !== false;
    }
}

if (!function_exists('publicRoutes')) {
    function publicRoutes($route = null)
    {
        $routes = [
            'backpack',
            'backpack.dashboard',
            'product.status-update',
        ];

        return $route
            ? in_array($route, $routes)
            : $routes;
    }
}

if (!function_exists('crudAccessList')) {
    /**
     * @return string[]
     */
    function crudAccessList(): array
    {
        return [
            'bulkdelete'   => 'bulkdelete',
            'bulkclone'    => 'bulkclone',
            'clone'        => 'clone',
            'create'       => 'create',
            'delete'       => 'delete',
            'fetch'        => 'fetch',
            'inlinecreate' => 'inlinecreate',
            'index'        => 'list',
            'show'         => 'show',
            'reorder'      => 'reorder',
            'update'       => 'update',

            'revisions' => 'revisions',
            'revise'    => 'revise',
        ];
    }
}
if (!function_exists('denyAccessArray')) {
    /**
     * @param $route
     * @return array
     */
    function denyAccessArray($route = null): array
    {
        $routeArray     = explode('.', $route);
        $crudAccessList = crudAccessList();
        $action         = array_pop($routeArray);
        $hasPermission  = userHasPermission($route);

        return $hasPermission
            ? []
            : [$crudAccessList[$action]];
    }
}
if (!function_exists('userCan')) {
    /**
     * @param $route
     * @return bool
     */
    function userCan($route = null): bool
    {
        return userHasPermission($route);
    }
}
if (!function_exists('userHasPermission')) {
    /**
     * @param $route
     * @return bool
     */
    function userHasPermission($route = null): bool
    {
        //$freePass = [...get_inline_routes(), ...get_fetch_routes()];
        $freePass = getAllRoutesName('.fetch', '-inline-');

        if (publicRoutes($route = $route ?? Route::currentRouteName()) || in_array($route, $freePass)) {
            return true;
        }

        $routePost = [
            'create'         => 'create',
            'store'          => 'create',
            'destroy'        => 'destroy',
            'edit'           => 'edit',
            'update'         => 'edit',
            'index'          => 'index',
            'search'         => 'index',
            'show'           => 'show',
            'showDetailsRow' => 'show',
            'reorder'        => 'reorder',
        ];

        $routeArr                 = explode('.', $route);
        $post                     = end($routeArr);
        $routeArr[key($routeArr)] = $routePost[$post];
        $route                    = implode('.', $routeArr);

        return backpack_user()->can($route);
    }
}

if (!function_exists('getFirstImage')) {
    /**
     * @param array $images
     * @return string
     */
    function getFirstImage(array $images): string
    {
        $url = count($images)
            ? $images[0]['url']
            : '';
        return imageUrl($url);
    }
}

if (!function_exists('imageUrl')) {
    /**
     * @param $url
     * @return string
     */
    function imageUrl($url): string
    {
        $imageUrl = asset('images/no-image.jpg');
        if (!empty($url) && file_exists(public_path($url))) {
            $imageUrl = asset($url);
        }
        return $imageUrl;
    }
}

if (!function_exists('discountPercentage')) {
    /**
     * @param $price
     * @param $discountPrice
     * @return int
     */
    function discountPercentage($price, $discountPrice): int
    {
        return ($discountPrice == 0 || $price == 0)
            ? 0
            : (($price - $discountPrice) * 100) / $price;
    }

}

if (!function_exists('reviewPercentage')) {
    /**
     * @param $rating
     * @return int
     */
    function reviewPercentage($rating): int
    {
        return $rating == 0
            ? 0
            : ($rating / 5) * 100;
    }
}

if (!function_exists('getRouteList')) {
    /**
     * @return array
     */
    function getRouteList(): array
    {
        $routeList = Route::getRoutes()->getRoutes();
        $routeList = collect($routeList)->map(function ($route) {
            return [
                'domain'     => $route->domain(),
                'method'     => implode('|', $route->methods() ?? []),
                'uri'        => $route->uri(),
                'name'       => $route->getName(),
                'action'     => $route->getActionName(),
                'middleware' => implode(', ', $route->middleware() ?? []),
            ];
        })->filter(function ($route) {
            return $route['action'] != null;
        })->toArray();

        return $routeList;
    }
}

if (!function_exists('setCompanyData')) {
    /**
     * @return DSCompany|Builder|Model
     */
    function setCompanyData(): Model|Builder|DSCompany
    {
        // get subdomain
        $urlArr  = explode('.', request()->getHost());
        $company = new DSCompany();

        if (count($urlArr) > 2) {
            $subdomain = $urlArr[0];

            $company = $company::query()
                ->where('subdomain', $subdomain)
                ->with('dsUser:id,company_id,name,email')
                ->firstOrFail();
        }

        // set subdomain's company to config
        Config::set('subdomain.company', $company->toArray());

        view()->share('company', $company);

        return $company;
    }
}

if (!function_exists('getSettingsUrl')) {
    /**
     * @param string $key
     * @return string
     */
    function getSettingsUrl(string $key): string
    {
        $setting = Setting::query()->where('key', $key)->first(['id', 'key']);
        return $setting->id ?? false
            ? route('setting.edit', $setting->id)
            : '#';
    }
}

if (!function_exists('canSeeGoTo')) {
    /**
     * @param string $from
     * @param string $to
     * @param string $entityName
     * @param string|null $routeName
     * @return bool
     */
    function canSeeGoTo(string $from, string $to, string $entityName, string $routeName = null): bool
    {
        return !("$entityName.$to" === ($routeName ?? (config('backpack.settings.route') . ".$to")));
    }
}

if (!function_exists('hideLinkFromBreadcrumbs')) {
    /**
     * @param $entityNamePlural
     * @param $label
     * @return bool
     */
    function hideLinkFromBreadcrumbs($entityNamePlural, $label): bool
    {
        $disableKeys = [
            Str::plural(config('backpack.settings.route')),
        ];

        return in_array($entityNamePlural, $disableKeys) && $entityNamePlural === $label;
    }
}

if (!function_exists('backpackSetting')) {
    /**
     * @param string $key
     * @return string|array|object|int
     */
    function backpackSetting(string $key): string|array|object|int
    {
        return BackpackSetting::get($key)
            ?: '[]';
    }
}

if (!function_exists('siteSetting')) {
    /**
     * @param string $key
     * @return string|array|object|int
     */
    function siteSetting(string $key): string|array|object|int
    {
        return SiteSetting::get($key)
            ?: '[]';
    }
}

// pdfUrl
if (!function_exists('pdfUrl')) {
    /**
     * @param string $url
     * @return string
     */
    function pdfUrl(string $url): string
    {
        $encrypt_url = encrypt(trim($url, '/'));

        $urlArr         = explode('/', $url);
        $urlFullName    = Arr::last($urlArr);
        $urlFullNameArr = explode('.', $urlFullName);
        $name           = $urlFullNameArr[0] ?? 'pdf';

        return route("pdf", [$encrypt_url, $name]);
    }
}

if (!function_exists('isShellAdminOrSuperAdmin')) {
    /**
     * @return bool
     */
    function isShellAdminOrSuperAdmin(): bool
    {
        return isShellAdmin() || isSuperAdmin();
    }
}

if (!function_exists('isSuperAdmin')) {
    /**
     * @return bool
     */
    function isSuperAdmin(): bool
    {
        return backpack_user()->hasRole('SuperAdmin');
    }
}

if (!function_exists('isAdmin')) {
    /**
     * @return bool
     */
    function isAdmin(): bool
    {
        return backpack_user()->hasRole('Admin');
    }
}

if (!function_exists('isShellAdmin')) {
    /**
     * @return bool
     */
    function isShellAdmin(): bool
    {
        return backpack_user()->hasRole('ShellAdmin');
    }
}

if (!function_exists('getActiveCycleCostQueryParam')) {
    /**
     * @param $slug
     * @return string
     */
    function getActiveCycleCostQueryParam($slug = null): string
    {
        $slug  = strtolower($slug ?? now()->format('F-Y'));
        $cycle = Cycle::query()->where('slug', $slug)->first();

        if ($cycle && $cycle->is_closed) {
            if (($cycle = firstOfCreateCycle($cycle->cycleSlug()))->is_closed) {
                $q = getActiveCycleCostQueryParam($cycle->slug);
            } else {
                $q = getQ($cycle);
            }
            return $q;
        } else if ($cycle && !$cycle->is_closed) {
            return getQ($cycle);
        }

        return '';
    }
}

if (!function_exists('getCycleCostQueryParam')) {
    /**
     * @param $slug
     * @return string
     */
    function getCycleCostQueryParam($slug = null): string
    {
        $slug  = strtolower($slug ?? now()->format('F-Y'));
        $cycle = Cycle::query()->where('slug', $slug)->first();

        if ($cycle) {
            return getQ($cycle);
        }

        return '';
    }
}


if (!function_exists('getQ')) {
    /**
     * @param $cycle
     * @return string
     */
    function getQ($cycle): string
    {
        $title = rawurlencode($cycle->title);
        return "?cycle_id=$cycle->id&cycle_id_text=$title";
    }
}

//get cycle from slug
if (!function_exists('getCycleFromSlug')) {
    /**
     * @param $slug
     * @return Model|Builder
     */
    function getCycleFromSlug($slug): Model|Builder
    {
        return Cycle::query()->where('slug', $slug)->first();
    }
}

//get next cycle slug from slug
if (!function_exists('getNextCycleSlugFromSlug')) {
    /**
     * @param $slug
     * @return string
     */
    function getNextCycleSlugFromSlug($slug): string
    {
        $cycle = getCycleFromSlug($slug);
        $cycle = $cycle->nextCycle();

        return $cycle->slug;
    }
}

// first of create a cycle
if (!function_exists('firstOfCreateCycle')) {
    /**
     * @param string|null $slug
     * @return Model|Builder|Cycle
     */
    function firstOfCreateCycle(string $slug = null): Model|Builder|Cycle
    {
        $date = $slug
            ? Carbon::parse($slug)
            : now();
        $slug = strtolower($date->format('F-Y'));

        return Cycle::query()->firstOrCreate([
            'slug' => $slug,
        ], [
            'title'      => $date->format('F - Y'),
            'start_date' => $date->format('Y-m-1'),
            'end_date'   => $date->addMonth()->format('Y-m-d'),
        ]);
    }
}

// latest closed cycle
if (!function_exists('latestClosedCycle')) {
    /**
     * @return Model|Builder|Cycle
     */
    function getLastClosedCycle(): Model|Builder|Cycle
    {
        return getLastUnclosedCycle()->previousCycle();
    }
}

// latest unclosed cycle
if (!function_exists('getLastUnclosedCycle')) {
    /**
     * @param string|null $slug
     * @return Cycle
     */
    function getLastUnclosedCycle(string $slug = null): Cycle
    {
        $slug  = strtolower($slug ?? now()->format('F-Y'));
        $cycle = Cycle::query()->where('slug', $slug)->first()
                 ?? firstOfCreateCycle($slug);

        if (
            $cycle
            && $cycle->is_closed
            && ($cycle = firstOfCreateCycle(/*Next cycle slug*/ $cycle->cycleSlug()))->is_closed
        ) {
            $cycle = getLastUnclosedCycle($cycle->slug);
        }

        return $cycle;
    }
}

if (!function_exists('getEMIQueryParam')) {
    /**
     * @return string
     */
    function getEMIQueryParam(): string
    {
        return "?status=Active";
    }
}

if (!function_exists('getAtLeastDigit')) {
    /**
     * @param $number
     * @return string
     */
    function getAtLeastDigit($number): string
    {
        return $number < 10
            ? '0' . $number
            : $number;
    }
}

if (!function_exists('getEmiAt')) {
    /**
     * @param string|null $date
     * @return Carbon
     */
    function getEmiAt(string $date = null): Carbon
    {
        $emiClosingDate = EMI::EMI_CLOSING_DATE ?? 28;
        $date           = $date ?? today()->format('Y-m-d');
        $emiAt          = Carbon::parse($date);
        if (Carbon::parse($date)->day <= $emiClosingDate) {
            $emiAt = $emiAt->subMonth();
        }
        return $emiAt->setDay($emiClosingDate)->endOfDay();
    }
}

// getCycleId
if (!function_exists('getCycleId')) {
    /**
     * @return int
     */
    function getCycleId(): int
    {
        if (!(($cycle_id = request()->cycle_id) && $cycle = Cycle::query()->find(request()->cycle_id))) {
            // $slug  = strtolower(now()->format('F-Y'));
            // $cycle = getCycleFromSlug($slug);
            $cycle = getLastUnclosedCycle();
        }

        return $cycle->id ?? $cycle_id;
    }
}

// getShellAdmin
if (!function_exists('getShellOrSuperAdmin')) {
    /**
     * @return Builder|Model|null
     */
    function getShellOrSuperAdmin(): Model|Builder|null
    {
        return User::query()->whereHas('roles', function ($q) {
            $q->whereIn('name', ['ShellAdmin', 'SuperAdmin']);
        })->firstOrFail();
    }
}

