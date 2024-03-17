<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class='nav-item mb-2'>Project</li>
@if(!isCustomer())
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-users"></i> <span>Customers</span></a></li>
@endif
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('project') }}'><i class='nav-icon la la-boxes'></i> Projects</a></li>
@if(!isCustomer())
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('controller') }}'><i class='nav-icon la la-cogs'></i> Controllers</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('sensor') }}'><i class='nav-icon la la-project-diagram'></i> Sensors</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('sensor-type') }}'><i class='nav-icon la la-bullhorn'></i> Sensor Types</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('aerator') }}'><i class='nav-icon la la-air-freshener'></i> Aerators</a></li>
<li class='nav-item mb-2'>Feeder</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('feeder') }}'><i class='nav-icon la la-bacon'></i> Feeders</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('feeder-history') }}'><i class='nav-icon la la-bacon'></i> Feeder histories</a></li>
@endif
<li class='nav-item mb-2'>Fish</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('fish') }}'><i class='nav-icon la la-fish'></i> Fish</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('fish-weight') }}'><i class='nav-icon la la-weight-hanging'></i> Fish weights</a></li>

<li class='nav-item mb-2'>Other</li>
@if(!isCustomer())
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('setting') }}'><i class='nav-icon la la-cog'></i> <span>Settings</span></a></li>
@endif

@if(isShellAdminOrSuperAdmin())
<!-- Footer Management -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#" title="Footer Link Management"><i class="nav-icon la la-link"></i> Footer Link Man.</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('footer-link-group') }}'><i class='nav-icon la la-external-link'></i> Link Group</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('footer-link') }}'><i class='nav-icon la la-external-link-square'></i> Link</a></li>
    </ul>
</li>
@endif

@if(!isCustomer())
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('contact-us') }}'><i class='nav-icon la la-envelope'></i> Contact us</a></li>
{{--<li class="nav-item"><a class="nav-link" href="{{ getSettingsUrl('about') }}"><i class="la la-address-book nav-icon"></i> {{ trans('About') }}</a></li>--}}

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('social') }}'><i class='nav-icon la la-share-alt'></i> Social</a></li>
@endif

@if(isShellAdminOrSuperAdmin())
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('route-list') }}'><i class='nav-icon la la-route'></i> Route lists</a></li>

    <!-- Backup -->
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-hdd"></i> Backup &amp; restore</a>
        <ul class="nav-dropdown-items">
            {{--<li class='nav-item'><a class='nav-link' href='{{ backpack_url('backup') }}'><i class='nav-icon la la-download'></i> Backups</a></li>--}}
            {{--<li class='nav-item'><a class='nav-link' href='{{ route('backup.table') }}'><i class='nav-icon la la-cloud-download'></i> Backup to seed</a></li>--}}
            @include("partials.menu-item-confirmation", [
                "text" => "Restore from seed",
                "icon" => "la la-cloud-upload",
                "url" => route("shell.command.artisan.migrate.fresh.seed"),
                "confirmation" => "Are you sure you want to restore from seed?"
            ])
            @include("partials.menu-item-confirmation", [
                "text" => "Backup to seed",
                "icon" => "la la-cloud-download",
                "url" => route("backup.table"),
                "confirmation" => "Are you sure you want to backup to seed?"
            ])
        </ul>
    </li>
@endif

@if(isShellAdminOrSuperAdmin())
<!-- command -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-terminal"></i> Command</a>
    <ul class="nav-dropdown-items">
        @include("partials.menu-item-confirmation", [
            "url" => route('shell.command.git.status', ['autoRedirect' => false]),
            "icon" => "la la-code-compare",
            "text" => "Git status",
            "confirmation" => "Are you sure you want to run Git status?"
        ])
        @if(isShellAdminOrSuperAdmin())
            <li class="nav-divider"></li>
            @include("partials.menu-item-confirmation", [
                "url" => route('shell.command.git.pull', ['autoRedirect' => false]),
                "icon" => "la la-code-pull-request-draft",
                "text" => "Git pull",
                "confirmation" => "Are you sure you want to pull the latest code from the remote repository?"
            ])
            @include("partials.menu-item-confirmation", [
                "url" => route('shell.command.git.commit', ['autoRedirect' => false]),
                "icon" => "la la-code-commit",
                "text" => "Git commit",
                "confirmation" => "Are you sure you want to commit the changes?"
            ])
            @include("partials.menu-item-confirmation", [
                "url" => route('shell.command.git.push', ['autoRedirect' => false]),
                "icon" => "la la-code-pull-request",
                "text" => "Git push",
                "confirmation" => "Are you sure you want to push the changes to the remote repository?"
            ])
            @include("partials.menu-item-confirmation", [
                "url" => route('shell.command.git.commit.push', ['autoRedirect' => false]),
                "icon" => "la la-code-fork",
                "text" => "Git commit & push",
                "confirmation" => "Are you sure you want to commit and push the changes to the remote repository?"
            ])
            {{--@include("partials.menu-item-confirmation", [--}}
            {{--"url" => route('shell.command.any.command', ['autoRedirect' => false]),--}}
            {{--"icon" => "la la-code-pull-request",--}}
            {{--"text" => "Git push",--}}
            {{--"confirmation" => "Are you sure you want to push the changes to the remote repository?"--}}
            {{--])--}}
            <li class="nav-divider"></li>
            @include("partials.menu-item-confirmation", [
                "url" => route('shell.command.git.stash', ['autoRedirect' => false]),
                "icon" => "la la-code-pull-request-closed",
                "text" => "Git stash",
                "confirmation" => "Are you sure you want to stash the changes?"
            ])
            <li class="nav-divider"></li>
            @include("partials.menu-item-confirmation", [
                "url" => route('shell.command.git.config', ['autoRedirect' => true]),
                "icon" => "la la-badge-check",
                "text" => "Git config",
                "confirmation" => "Are you sure you want to run git config with Name: ". backpack_auth()->user()->name ." and Email: ". "codegarage6@gmail.com" ."?"
            ])
            @include("partials.menu-item-confirmation", [
                "url" => route('shell.command.any.command', ['autoRedirect' => false]),
                "icon" => "la la-question",
                "text" => "Shell command",
                "prompt" => true,
                "confirmation" => "Are you sure you want to run the command?"
            ])
        @endif

        <script src="{{ asset('assets/js/sidebar-content.js') }}"></script>
    </ul>
</li>
@endif

<!-- Users, Roles, Permissions -->
@if(isShellAdminOrSuperAdmin())
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>
@endif

@if(isShellAdminOrSuperAdmin())
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('log') }}'><i class='nav-icon la la-terminal'></i> Logs</a></li>
@endif

@if(!isCustomer())
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon la la-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
@endif
