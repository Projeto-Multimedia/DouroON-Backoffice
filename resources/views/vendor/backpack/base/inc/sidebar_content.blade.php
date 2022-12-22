{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

@if(backpack_user()->hasRole('admin'))
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-sitemap"></i> App Users</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('end-user') }}"><i class="las la-user-secret"></i> End users</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('companies') }}"><i class="la la-building"></i> Companies</a></li>
    </ul>
</li>
@endif
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-tags"></i> Posts</a>
    <ul class="nav-dropdown-items">
        @if(backpack_user()->hasRole('admin') || backpack_user()->hasRole('moderator'))
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user-post') }}"><i class="nav-icon las la-envelope"></i> User posts</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('approve-post') }}"><i class="nav-icon las la-envelope"></i> Approve User Posts</a></li>
        @endif
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('company-post') }}"><i class="nav-icon las la-envelope-open-text"></i> Company posts</a></li>
    </ul>
</li>

