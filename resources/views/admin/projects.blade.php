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
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
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
          <h6 class="font-weight-bolder text-white mb-0">Tables</h6>
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
              <h6>List of report task compilation</h6>
              @if(Auth::user()->getRoleNames()[0] == 'admin')
                <button class="btn btn-info btn-xs edit" data-bs-toggle="modal" data-bs-target="#createModal">New Report task compilation</button>
                
              @endif
             
               @if(Auth::user()->getRoleNames()[0] == 'manager')
               
                <button class="btn btn-info btn-xs edit" data-bs-toggle="modal" data-bs-target="#createModalUser">New user Profile</button>
              @endif
             
              @include('shared.notification')
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0 display" id="example" style="width:100%">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                     
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created By</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Project Type</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deadline</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Department</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($projects as $proj)
                    <tr>
                      
                      <td>
                        <div class="d-flex px-2 py-1">
                          
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{$proj->title}}</h6>
                            
                          </div>
                        </div>
                      </td>
                     
                      <td class="align-middle text-center text-sm">
                        @if($proj->status_id == 1)
                          <span class="badge badge-sm bg-gradient-success">Active</span>
                        @elseif($proj->status_id == 0)
                          <span class="badge badge-sm bg-gradient-danger">Archived</span>
                        @elseif($proj->status_id == 2)
                          <span class="badge badge-sm bg-gradient-secondary">Completed</span>
                        @endif
                        
                      </td>
                      <td class="align-middle text-center">
                        @if(Auth::user()->getRoleNames()[0] == 'manager_limited')
                          <span class="text-secondary text-xs font-weight-bold">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</span>
                        @elseif(Auth::user()->getRoleNames()[0] == 'manager_limited')
                          <span class="text-secondary text-xs font-weight-bold">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</span>
                        @else
                        <span class="text-secondary text-xs font-weight-bold">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</span>
                        @endif
                        
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{$proj->created_at}}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{$proj->project_type}}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{$proj->deadline}}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{$proj->title}}</span>
                      </td>
                      <td class="align-middle">
                        

                        @if($proj->status_id == 1)
                        @if(Auth::user()->getRoleNames()[0] != 'manager_limited')
                          
                          <button class="btn btn-default btn-xs completed" data-bs-toggle="modal" data-bs-target="#completedModal" value="{{$proj->id}}" style="width: 90px">Completed</button>
                          <a href="{{route('admin_task_list',$proj->id)}}" class="btn btn-warning btn-xs" style="width: 90px">View Task</a>
                         <!--  <button class="btn btn-primary btn-xs assign" data-bs-toggle="modal" data-bs-target="#assignsModal" value="{{$proj->id}}">Assign Department</button> -->
                         @endif

                         @if(Auth::user()->getRoleNames()[0] == 'admin')
                         <button class="btn btn-info btn-xs updateProject" data-bs-toggle="modal" data-bs-target="#editModal" value="{{$proj->id}}" style="width: 90px">Edit</button>
                          <button class="btn btn-danger btn-xs archive" data-bs-toggle="modal" data-bs-target="#statusModal" value="{{$proj->id}}" style="width: 90px">Archive</button>
                         @endif
                         
                        @elseif($proj->status_id == 0)
                          <button class="btn btn-success btn-xs archive" data-bs-toggle="modal" data-bs-target="#statusModal" value="{{$proj->id}}" style="width: 90px">Activate</button>
                        @elseif($proj->status_id == 2)
                          <a href="{{route('admin_task_list',$proj->id)}}" class="btn btn-warning btn-xs" style="width: 90px">View Task</a>
                          <button class="btn btn-success btn-xs archive" data-bs-toggle="modal" data-bs-target="#statusModal" value="{{$proj->id}}" style="width: 90px">Activate</button>

                           @if(Auth::user()->getRoleNames()[0] == 'admin')
                            <button class="btn btn-default btn-sm deleteAllProject" data-bs-toggle="modal" data-bs-target="#deleteProjectModal" value="{{$proj->id}}" style="width: 90px">DELETE</button>
                           @endif
                        @endif
                        
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
  <div class="modal" id="createModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Report Information</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form role="form" action="{{route('admin_create_projects')}}" method="POST">
        <!-- Modal body -->
        <div class="modal-body">
           
        @csrf

        <div class="mb-3">
          <label>Report Deadline</label>
          <input type="date" class="form-control" name="deadline" required >
        </div>

        <div class="mb-3">
          <label>Report Type</label>
           <select class="form-control" required name="project_type">
            @foreach($report_types as $rep)
              <option value="{{$rep->name}}">{{$rep->name}}</option>
            @endforeach
            
           </select>
        </div>

        <div class="form-group">
          <label>Select Assigned Department</label>
          <select class="form-control" name="department_id" required>
            <option></option>
            @foreach($departments as $dept)
              <option value="{{$dept->id}}">{{$dept->name}}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label>Report Name</label>
          <input type="text" class="form-control" placeholder="Name" aria-label="Name" name="title" required id="name">
        </div> 
        <div class="mb-3">
          <label>Report Description</label>
          <textarea class="form-control" name="description" required></textarea>
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

  <div class="modal" id="editModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Update Report Information</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form role="form" action="{{route('admin_update_projects')}}" method="POST">
        <!-- Modal body -->
        <div class="modal-body">
           
        @csrf
        <input type="hidden" name="project_id" id="updateProjectId">
        <div class="mb-3">
          <label>Report Name</label>
          <input type="text" class="form-control" placeholder="Name" aria-label="Name" name="title" required id="editTitle">
        </div> 
        <div class="mb-3">
          <label>Report Description</label>
          <textarea class="form-control" name="description" required id="editDescription"></textarea>
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

  <div class="modal" id="statusModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Change Status?</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form role="form" action="{{route('admin_change_projects_status')}}" method="POST">
        <!-- Modal body -->
        <div class="modal-body">
           
        @csrf
        <input type="hidden" name="project_id" id="statusProjectId">
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn bg-gradient-primary">Yes</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
        </form>

      </div>
    </div>
  </div>

  <div class="modal" id="completedModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Are you sure everything is completed?</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form role="form" action="{{route('admin_completed_project')}}" method="POST">
        <!-- Modal body -->
        <div class="modal-body">
           
        @csrf
        <input type="hidden" name="project_id" id="completedProject">
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn bg-gradient-primary">Yes</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
        </form>

      </div>
    </div>
  </div>

    <div class="modal" id="assignsModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Assign Project</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form role="form" action="{{route('admin_assign_project')}}" method="POST">
        <!-- Modal body -->
        <div class="modal-body">
           
        @csrf
        <input type="hidden" name="project_id" id="assignTask">
        <div class="form-group">
          <label>Select Assigned Department</label>
          <select class="form-control" name="department_id" required>
            <option></option>
            @foreach($departments as $dept)
              <option value="{{$dept->id}}">{{$dept->name}}</option>
            @endforeach
          </select>
        </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn bg-gradient-primary">Yes</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
        </form>

      </div>
    </div>
  </div>

  <div class="modal" id="createModalUser">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">New User Profile Informations</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form role="form" action="{{route('admin_create_faculty')}}" method="POST">
        <!-- Modal body -->
        <div class="modal-body">
           
                  @csrf
                  
                  <div class="mb-3">
                    <label>First Name <span style="color: red; margin-bottom: -10px;">*</span></label>
                    <input type="text" class="form-control" placeholder="First Name" aria-label="Name" name="first_name" required id="firstName1">
                  </div>
                  <div class="mb-3">
                    <label>Last Name <span style="color: red; margin-bottom: -10px;">*</span></label>
                    <input type="text" class="form-control" placeholder="Last Name" aria-label="Name" name="last_name" required id="lastName1">
                  </div>
                  <div class="mb-3">
                    <label>Email must be valid (@su.edu.ph) format <span style="color: red; margin-bottom: -10px;">*</span></label>
                    <input type="email" class="form-control email_create" placeholder="Email" aria-label="Email" name="email" required id="email">
                  </div>

            
                  <div class="mb-3">
                    <label>Enter Password <span style="color: red; margin-bottom: -10px;">*</span></label>
                    <input type="password" class="form-control" placeholder="Password" aria-label="Password" name="password">
                  </div>

                  <div class="mb-3">
                    <label>Re-Enter Password <span style="color: red; margin-bottom: -10px;">*</span></label>
                    <input type="password" class="form-control" placeholder="Repeat Password" aria-label="Password" name="repeat_password" required>
                  </div>
                  
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2 submit_user">Submit</button>
                  </div>
                  
                
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
        </form>

      </div>
    </div>
</div>


<div class="modal" id="deleteProjectModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Warning all data of this project will be deleted?</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form role="form" action="{{route('delete_all_projects')}}" method="POST">
        <!-- Modal body -->
        <div class="modal-body">
           
        @csrf
        <input type="hidden" name="project_id" id="deleteProjectAll">
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn bg-gradient-primary">Yes</button>
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
  <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $('#example').DataTable();
      
      var find_project_url = "{{route('admin_find_projects')}}";
      var token = "{{Session::token()}}";

      $(".archive").click(function(){
        var project_id = $(this).val();
        $("#statusProjectId").val(project_id);

      });

       $(".deleteAllProject").click(function(){
        var project_id = $(this).val();
        $("#deleteProjectAll").val(project_id);

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