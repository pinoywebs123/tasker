<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Dashboard
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{URL::to('/assets/css/nucleo-icons.css')}}" rel="stylesheet" />
  <link href="{{URL::to('/assets/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="{{URL::to('/assets/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{URL::to('/assets/css/argon-dashboard.css?v=2.0.4')}}" rel="stylesheet" />
</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="# " target="_blank">
        <img src="{{URL::to('/assets/img/logo-ct-dark.png')}}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">{{Auth::user()->name}}</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      @include('shared.side')
    </div>
    
  </aside>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Tables</li>
          </ol>
          
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            
          </div>
          <ul class="navbar-nav  justify-content-end">
            
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
            
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bell cursor-pointer"></i>
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New message</span> from Laur
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          13 minutes ago
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                
                
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              
              <h3>Project Title: {{$find_project->title}}</h3>
              <h6>Task Information</h6>
              @include('shared.notification')
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <div class="container">
                  <h3>Task Title: {{$find_task->title}}</h3>
                  <h6>Task Description: {{$find_task->description}}</h6>

                  <br>
                  <p>
                    @foreach($task_files as $file)
                      <form action="{{route('download_task')}}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="url" value="{{$file->file_name}}">
                        <p>
                          <?php 
                            $file_name = explode("/",$file->file_name);
                            echo $file_name[1];
                          ?>
                         
                        </p>
                        <button type="submit" class="btn btn-danger btn-xs">DOWNLOAD NOW</button>
                      </form>

                    @endforeach
                  

                  <button class="btn btn-primary btn-xs upload" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload</button> 
                  </p>
                  <br>
                  <br>
                  <br>
                  <br>
                  <ul class="list-group">
                    @if($comments->count() > 0)
                      <li class="list-group-item active" aria-current="true">Comment Lists</li>
                      @foreach($comments as $com)
                      <li class="list-group-item">
                        {{$com->user->name}} : {{$com->comment}}
                        <br>
                        <p style="font-size: 8px;">Created: {{$com->created_at->diffForHumans()}}</p>
                      </li>

                      @endforeach  
                    @else
                        No Comment
                    @endif
                  </ul>
                  <br>
                  <form action="{{route('share_task_comment')}}" method="POST">
                    @csrf
                    <div class="form-group">
                      <label>Comment Here: </label>
                      <input type="hidden" name="task_id" value="{{Request::segment(3)}}">
                      <textarea class="form-control" name="comment" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </main>

<div class="modal" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Are you sure you want to delete?</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{route('admin_delete_user')}}" method="POST">
        @csrf
      <!-- Modal body -->
      <div class="modal-body">
        <input type="hidden" name="user_id" id="delete_user_id">
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
      </form>

    </div>
  </div>
</div>

 <div class="modal" id="uploadModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Change Status?</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form role="form" action="{{route('upload_task')}}" method="POST" enctype="multipart/form-data">
        <!-- Modal body -->
        <div class="modal-body">
           
        @csrf
        <input type="hidden" name="project_id" value="{{Request::segment(4)}}">
        <input type="hidden" name="task_id" value="{{Request::segment(3)}}">
         <div class="mb-3">
          <label>Task Type</label>
           <select class="form-control" required>
             <option>Photo</option>
             <option>Document</option>
             <option>Physical Task</option>
           </select>
        </div>

        <div class="mb-3">
          <label>Task File</label>
          <input type="file" name="task_file" class="form-control" required>
        </div> 

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn bg-gradient-primary">Submit</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
        </form>

      </div>
    </div>
  </div>

  
  <!--   Core JS Files   -->
  <script src="{{URL::to('/assets/js/core/popper.min.js')}}"></script>
  <script src="{{URL::to('/assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{URL::to('/assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{URL::to('/assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{URL::to('/assets/js/argon-dashboard.min.js?v=2.0.4')}}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      
    });
  </script>
</body>

</html>