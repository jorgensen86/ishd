<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('dashboard') }}" class="brand-link">
    <img src="{{ asset('image/admin/AdminLTELogo.png') }}" alt="AdminLTE Logo"
      class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">ISHD</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('image/admin/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- dashboard-menu -->
        <li class="nav-item menu-open">
          <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : null }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>{{ __('sidebar.dashboard') }}</p>
          </a>
        </li>
        <!-- /.dashboard-menu -->

        <!-- tickets-menu -->
         <li class="nav-item {{ request()->is('ticket/*') ? 'menu-open' : null }}">
          <a href="#" class="nav-link {{ request()->is('ticket/*') ? 'active' : null }}">
            <i class="nav-icon fas fa-tags"></i>
            <p>{{ __('sidebar.ticket') }} <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('ticket.index', ['queue_id'=> 1]) }}" class="nav-link {{ request()->is('ticket/queue/*') ? 'active' : null }}">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>{{ __('sidebar.ticket_list') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('ticket.create') }}" class="nav-link {{ request()->is('ticket/ticket/create') ? 'active' : null }}">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>{{ __('sidebar.ticket_new') }}</p>
              </a>
            </li>
          </ul>
        </li>
         <!-- ./ tickets-menu -->   

         <!-- emails-menu -->
         <li class="nav-item {{ request()->is('email/*') ? 'menu-open' : null }}">
          <a href="#" class="nav-link {{ request()->is('email/*') ? 'active' : null }}">
            <i class="nav-icon fas fa-envelope"></i>
            <p>{{ __('sidebar.email') }} <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('email.index', 1) }}" class="nav-link {{ request()->is('email/queue*') ? 'active' : null }}">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>{{ __('sidebar.email_list') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('imap.index') }}" class="nav-link {{ request()->is('email/imap') ? 'active' : null }}">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>{{ __('sidebar.email_accounts') }}</p>
              </a>
            </li>
          </ul>
        </li>
         <!-- ./ emails-menu -->        

         <!-- users-menu -->
        @canany('view_users', 'view_clients')  
        <li class="nav-item {{ request()->is('user/*') ? 'menu-open' : null }}">
          <a href="#" class="nav-link {{ request()->is('user/*') ? 'active' : null }}">
            <i class="nav-icon fas fa-user-alt"></i>
            <p>{{ __('sidebar.user') }} <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            @can('view_users')    
              <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link {{ request()->is('user/user') ? 'active' : null }}">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>{{ __('sidebar.user_list') }}</p>
                </a>
              </li>
            @endcan
            <li class="nav-item">
              <a href="{{ route('client.index') }}" class="nav-link {{ request()->is('user/client') ? 'active' : null }}">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>{{ __('sidebar.client_list') }}</p>
              </a>
            </li>
          </ul>
        </li>
        @endcanany
         <!-- ./ users-menu -->

        <!-- settings-menu -->
        <li class="nav-item {{ request()->is('setting/*') ? 'menu-open' : null }}">
          <a href="{{ route('user.index') }}" class="nav-link {{ request()->is('setting/*') ? 'active' : null }}">
            <i class="nav-icon fas fa-wrench"></i>
            <p>{{ __('sidebar.setting') }} <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('setting.index') }}" class="nav-link {{ request()->is('setting/setting') ? 'active' : null }}">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>{{ __('sidebar.setting') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('queue.index') }}" class="nav-link {{ request()->is('setting/queue') ? 'active' : null }}">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>{{ __('sidebar.queue') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('subject.index') }}" class="nav-link {{ request()->is('setting/subject') ? 'active' : null }}">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>{{ __('sidebar.subject') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('role.index') }}" class="nav-link {{ request()->is('setting/role') ? 'active' : null }}">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>{{ __('sidebar.role') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('permission.index') }}" class="nav-link {{ request()->is('setting/permission') ? 'active' : null }}">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>{{ __('sidebar.permission') }}</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- settings-menu -->

        <!-- logout-menu -->
        <li class="nav-item menu-open">
          <a href="{{ route('logout') }}" class="nav-link">
            <i class="nav-icon fas fa-rotate-left"></i>
            <p>{{ __('sidebar.logout') }}</p>
          </a>
        </li>
        <!-- /.logout-menu -->
        
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>