<ul class="navbar-nav">
      @if(Auth::user()->getRoleNames()[0] == 'admin')
        <li class="nav-item">
          <a class="nav-link active" href="{{route('admin_home')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Users</span>
          </a>
        </li>
      @endif

      @if(Auth::user()->getRoleNames()[0] == 'manager' || Auth::user()->getRoleNames()[0] == 'admin')
        <li class="nav-item">
          <a class="nav-link " href="{{route('admin_projects')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Projects</span>
          </a>
        </li>
        
     @endif

      @if( Auth::user()->getRoleNames()[0] == 'tasker' )
        <li class="nav-item">
          <a class="nav-link " href="{{route('tasker_home')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Projects</span>
          </a>
        </li>
        
      @endif 
       
        
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
        </li>
        
        <li class="nav-item">
          <a class="nav-link " href="{{route('admin_logout')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-copy-04 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Sign Out</span>
          </a>
        </li>
        
      </ul>