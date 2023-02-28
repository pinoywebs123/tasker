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
      <a class="navbar-brand m-0" href=" # " target="_blank">
        <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</span>
        <br />
        <span class="ms-1 font-weight-bold" >{{Auth::user()->department->name}}</span>
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
          <h6 class="font-weight-bolder text-white mb-0">System Maintenance Setup</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            
          </div>
          
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">

      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              Department List
              
            </div>
            <div class="card-body px-0 pt-0 pb-2">
             <div class="container">
              <button data-bs-toggle="modal" data-bs-target="#departmentModal" class="btn btn-primary btn-xs">New</button>
              <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                     
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($departments as $dept)
                      <tr>
                        <td>
                        <div class="d-flex px-2 py-1">
                          
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{strtoupper($dept->name)}}</h6>
                            
                          </div>
                        </div>
                      </td>
                      <td>
                        <a href="{{route('admin_delete_department', $dept->id)}}" class="btn btn-danger btn-xs">Delete</a>
                      </td>
                      </tr>
                    @endforeach
                    
                  </tbody>
                </table>
             </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
            
        @include('shared.notification')

       <!--  <div class="col-4">
          <div class="card mb-4">
            <div class="card-header pb-0">
              Department List
              <br>
              <button data-bs-toggle="modal" data-bs-target="#departmentModal" class="btn btn-primary btn-xs">New</button>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                     
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($departments as $dept)
                      <tr>
                        <td>
                        <div class="d-flex px-2 py-1">
                          
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{strtoupper($dept->name)}}</h6>
                            
                          </div>
                        </div>
                      </td>
                      <td>
                        <a href="{{route('admin_delete_department', $dept->id)}}" class="btn btn-danger btn-xs">Delete</a>
                      </td>
                      </tr>
                    @endforeach
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div> -->

        <!-- <div class="col-4">
          <div class="card mb-4">
            <div class="card-header pb-0">
              Position List
              <br>
              <button data-bs-toggle="modal" data-bs-target="#positionModal" class="btn btn-primary btn-xs">New</button>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                     
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($positions as $post)
                      <tr>
                        <td>
                        <div class="d-flex px-2 py-1">
                          
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{strtoupper($post->name)}}</h6>
                            
                          </div>
                        </div>
                      </td>
                      <td>
                        <a href="{{route('admin_delete_position', $post->id)}}" class="btn btn-danger btn-xs">Delete</a>
                      </td>
                      </tr>
                    @endforeach
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div> -->

       <!--  <div class="col-4">
          <div class="card mb-4">
            <div class="card-header pb-0">
              User Type List
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($roles as $role)
                      <tr>
                        <td>
                        <div class="d-flex px-2 py-1">
                          
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{strtoupper($role->name)}}</h6>
                            
                          </div>
                        </div>
                      </td>
                      </tr>
                    @endforeach
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div> -->


      </div>

       <div class="row">
            
       

        <div class="col-4">
          <div class="card mb-4">
            <div class="card-header pb-0">
              Report Type
              <br>
              <button data-bs-toggle="modal" data-bs-target="#reportModal" class="btn btn-primary btn-xs">New</button>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($report_types as $rept)
                      <tr>
                        <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                          <p class="text-xs text-secondary mb-0">{{strtoupper($rept->name)}}</p>
                        </div>
                      </td>
                        
                      <td>
                        <a href="{{route('admin_delete_report_type', $rept->id)}}" class="btn btn-danger btn-xs">Delete</a>
                      </td>
                      </tr>
                    @endforeach
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-4">
          <div class="card mb-4">
            <div class="card-header pb-0">
              Task File Type
              <br>
              <button data-bs-toggle="modal" data-bs-target="#fileModal" class="btn btn-primary btn-xs">New</button>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($file_types as $file)
                      <tr>
                        <td>
                        <div class="d-flex px-2 py-1">
                          
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{strtoupper($file->name)}}</h6>
                            
                          </div>
                        </div>
                      </td>
                      <td>
                        <a href="{{route('admin_delete_file_type', $file->id)}}" class="btn btn-danger btn-xs">Delete</a>
                      </td>
                      </tr>
                    @endforeach
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

       


      </div>


      
      
    </div>
  </main>

   <div class="modal" id="fileModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">File Type Name?</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form role="form" action="{{route('admin_create_file_type')}}" method="POST">
        <!-- Modal body -->
        <div class="modal-body">
           
        @csrf
        <input type="text" name="name" class="form-control" required>
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

  <div class="modal" id="reportModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Report Type Name?</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form role="form" action="{{route('admin_create_report_type')}}" method="POST">
        <!-- Modal body -->
        <div class="modal-body">
           
        @csrf
        <input type="text" name="name" class="form-control" required>
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

  <div class="modal" id="departmentModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Department Name?</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form role="form" action="{{route('admin_create_department')}}" method="POST">
        <!-- Modal body -->
        <div class="modal-body">
           
        @csrf
        <input type="text" name="name" class="form-control" required>
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

  <div class="modal" id="positionModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Position Information?</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form role="form" action="{{route('admin_create_position')}}" method="POST">
        <!-- Modal body -->
        <div class="modal-body">
           
        @csrf
        <input type="text" name="name" class="form-control" required>
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
      var find_project_url = "{{route('admin_find_projects')}}";
      var token = "{{Session::token()}}";

      $(".archive").click(function(){
        var project_id = $(this).val();
        $("#statusProjectId").val(project_id);

      });

      $(".completed").click(function(){
        var project_id = $(this).val();
        $("#completedProject").val(project_id);

      });

      $(".assign").click(function(){
        var project_id = $(this).val();
        $("#assignTask").val(project_id);

      });

      $(".updateProject").click(function(){
          var project_id = $(this).val();
          $("#updateProjectId").val(project_id);
          $.ajax({
           type:'POST',
           url:find_project_url,
           data:{_token: token, project_id : project_id},
           success:function(data) {
              console.log(data);
              $("#editTitle").val(data.title);
              $("#editDescription").val(data.description);
              
           }
        });


      });

    });
  </script>
</body>

</html>