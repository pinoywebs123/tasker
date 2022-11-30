<ul class="navbar-nav">
      @if(Auth::user()->getRoleNames()[0] == 'admin')
        <li class="nav-item">
          <a class="nav-link " href="{{route('admin_home')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Users</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link " href="{{route('admin_system_maintenance')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-atom text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">User Input Management</span>
          </a>
        </li>

      @endif

      @if(Auth::user()->getRoleNames()[0] == 'manager' || Auth::user()->getRoleNames()[0] == 'admin')
        <li class="nav-item">
          <a class="nav-link " href="{{route('admin_projects')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Report Task Compilation</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link " href="{{route('admin_archive_projects')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-archive-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Archive Reports</span>
          </a>
        </li>
        
     @endif

      @if( Auth::user()->getRoleNames()[0] == 'tasker' )
        <li class="nav-item">
          <a class="nav-link " href="{{route('tasker_home')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Report Task Compilation</span>
          </a>
        </li>
        
      @endif 

      @if( Auth::user()->getRoleNames()[0] == 'manager_limited' )
        <li class="nav-item">
          <a class="nav-link " href="{{route('admin_projects')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Report Task Compilation</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link " href="{{route('admin_archive_projects')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Archive Reports</span>
          </a>
        </li>
        
      @endif 

     
       
       
        
        <li class="nav-item">
          <a class="nav-link " href="{{route('admin_logout')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-copy-04 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Sign Out</span>
          </a>
        </li>
        
      </ul>