<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item d-none d-lg-block" style="border-bottom: 1px solid #4b545c;">
    <a class="nav-link navbar-brand mr-0" href="{{ backpack_url('/') }}" title="{{ config('backpack.base.project_name') }}">
        {!! config('backpack.base.project_name') !!}
    </a>
  </li>
  <li class="nav-item nav-dropdown d-none d-lg-block" style="border-bottom: 1px solid #4b545c; padding-bottom: 6px;">
      <a class="nav-link nav-dropdown-toggle" href="#">
      <span style="margin-left: 5px">{{ backpack_auth()->user()->name }}</span>
      </a>
      <ul class="nav-dropdown-items">
          <li class="nav-item"><a class="nav-link" href="{{ route('backpack.account.info') }}"><i class="nav-icon la la-user"></i> <span>{{ trans('backpack::base.my_account') }}</span></a></li>
          <li class="nav-item"><a class="nav-link" href="{{ backpack_url('logout') }}"><i class="nav-icon la la-lock"></i> <span>{{ trans('backpack::base.logout') }}</span></a></li>
          <!-- <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li> -->
      </ul>
</li>
@if(backpack_user()->hasRole('Super Admin'))
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>
@endif
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<!-- @includeWhen(class_exists(\Backpack\DevTools\DevToolsServiceProvider::class), 'backpack.devtools::buttons.sidebar_item') -->
@if(backpack_user()->hasRole('Super Admin'))
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('driver') }}'><i class='nav-icon la la-car-side'></i> Drivers</a></li>
@endif
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('booking') }}'><i class='nav-icon la la-calendar-check'></i> Bookings</a></li>
@if(backpack_user()->hasRole('Client'))
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('consignee') }}'><i class='nav-icon la la-address-book'></i> Address Book</a></li>
@endif