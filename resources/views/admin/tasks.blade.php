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
        <img src="{{URL::to('/assets/img/logo-ct-dark.png')}}" class="navbar-brand-img h-100" alt="main_logo">
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
               <ul class="nav nav-tabs nav-justified">
                <li class="nav-item">
                  <a class="nav-link active" href="{{route('admin_task_list',Request::segment(2))}}">Task List</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('admin_task_file_list',Request::segment(2))}}">Task Files</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('admin_task_schedule_list',Request::segment(2))}}">Task Schedule</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('admin_task_timeline_list',Request::segment(2))}}">Task Timeline</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Task Calendar</a>
                </li>
                
              </ul>
              <br>
              
              @if($find_project->status_id == 1)
                @if(Auth::user()->getRoleNames()[0] == 'admin')
                  <button class="btn btn-info btn-xs edit" data-bs-toggle="modal" data-bs-target="#createModal">Add Task</button>
                @endif
              @endif
              
              <h3 class="text-center">{{$find_assign_project->project->project_type}} to {{isset($find_assign_project->department->name) ? 'Task of '.$find_assign_project->department->name : 'None'}}</h3>
              <p>Arrange By: </p>
              <form  id="arrangeForm" action="" method="GET">
                @csrf
                <select id="arrangeSelect" name="arrange_by">
                  <option>Select Here</option>
                  <option value="Normal">All Task</option>
                  <option value="Sub-Task">Sub-Task</option>
                </select>
              </form>
              @include('shared.notification')
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                     
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deadline</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Last Edited By</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Last Edited</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($tasks as $task)
                    <tr>
                      
                      <td>
                        <div class="d-flex px-2 py-1">
                          
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{$task->title}}</h6>
                            
                          </div>
                        </div>
                      </td>
                     
                      <td class="align-middle text-center text-sm">
                       @if($task->status_id == 1)
                          <span class="badge badge-sm bg-gradient-info">Active</span>
                        @elseif($task->status_id == 0)
                          <span class="badge badge-sm bg-gradient-danger">Inactive</span>
                        @elseif($task->status_id == 2)
                          <span class="badge badge-sm bg-gradient-success">Completed</span>
                        @endif
                        
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{$task->created_at}}</span>
                      </td>
                       <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{$task->deadline}}</span>
                      </td>
                        <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{$task->user->username}}</span>
                      </td>
                      </td>
                       <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{$task->updated_at}}</span>
                      </td>
                      <td class="align-middle">

                       
                          @if(Auth::user()->getRoleNames()[0] == 'admin')
                           <button class="btn btn-info btn-xs updateProject" data-bs-toggle="modal" data-bs-target="#editModal" value="{{$task->id}}" style="width: 80px">Edit</button>
                           @endif

                          @if($task->status_id == 1 || $task->status_id == 2 || $task->status_id == 0)
                            @if(Auth::user()->getRoleNames()[0] == 'admin')
                            <button class="btn btn-primary btn-xs archive" data-bs-toggle="modal" data-bs-target="#statusModal" value="{{$task->id}}" style="width: 80px">Status</button>

                             <button class="btn btn-danger btn-xs delete"  data-bs-toggle="modal" data-bs-target="#deleteModal" value="{{$task->id}}" style="width: 80px">Delete</button>
                           
                          @endif 
                             <button class="btn btn-primary btn-xs upload" data-bs-toggle="modal" data-bs-target="#uploadModal" value="{{$task->id}}">Upload</button>
                             <a href="{{route('share_view_task',['task_id' => $task->id, 'project_id'=> Request::Segment(2)])}}" class="btn btn-info btn-xs" style="width: 80px">View Task</a>

                           

                          @elseif($task->status_id == 0)
                            <button class="btn btn-success btn-xs archive" data-bs-toggle="modal" data-bs-target="#statusModal" value="{{$task->id}}" style="width: 80px">Activate</button>
                            
                          @endif
                        
                      

                        

                       

                      </td>
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
          <h4 class="modal-title">Task Informations</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form role="form" action="{{route('admin_create_task')}}" method="POST" enctype="multipart/form-data">
        <!-- Modal body -->
        <div class="modal-body">
           
        @csrf
        <input type="hidden" name="project_id" value="{{Request::segment(2)}}">
        <div class="mb-3">
          <label>Task Name</label>
          <input type="text" class="form-control" placeholder="Name" aria-label="Name" name="title" required id="name">
        </div> 
        <div class="mb-3">
          <label>Task Description</label>
          <textarea class="form-control" name="description" required></textarea>
        </div> 
        <div class="mb-3">
          <label>Task Deadline</label>
          <input type="date" class="form-control" name="deadline" required >
        </div>
        <div class="mb-3">
          <label>Task Type</label>
           <select class="form-control" required name="file_type">
            @foreach($file_types as $file)
              <option value="{{$file->name}}">{{$file->name}}</option>
            @endforeach
            
           </select>
          </div>
        <div class="mb-3">
          <label>Task File</label>
          <input type="file" name="task_file" class="form-control">
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
          <h4 class="modal-title">Task Informations</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form role="form" action="{{route('admin_update_task')}}" method="POST">
        <!-- Modal body -->
        <div class="modal-body">
           
        @csrf
        <input type="hidden" name="task_id" id="updateProjectId">
        <div class="mb-3">
          <label>Task Name</label>
          <input type="text" class="form-control" placeholder="Name" aria-label="Name" name="title" required id="editTitle">
        </div> 
        <div class="mb-3">
          <label>Task Deadline</label>
          <input type="date" class="form-control" name="deadline" required id="deadline_get">
        </div>
        <div class="mb-3">
          <label>Task Description</label>
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

        <form role="form" action="{{route('admin_change_task_status')}}" method="POST">
        <!-- Modal body -->
        <div class="modal-body">
           
        @csrf
        <input type="hidden" name="task_id" id="statusProjectId">
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

  <div class="modal" id="deleteModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Are you sure to delete?</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form role="form" action="{{route('admin_delete_task')}}" method="POST">
        <!-- Modal body -->
        <div class="modal-body">
           
        @csrf
        <input type="hidden" name="task_id" id="deleteProjectId">
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

  <div class="modal" id="uploadModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Upload File?</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form role="form" action="{{route('upload_task')}}" method="POST" enctype="multipart/form-data">
        <!-- Modal body -->
        <div class="modal-body">
           
        @csrf
        
        
        <input type="hidden" name="task_id" id="task_list_id">
         <div class="mb-3">
          <label>Task Type</label>
           <select class="form-control" required name="file_type">
             <option value="Image">Photo</option>
             <option value="Document">Document</option>
             <option value="Physical Task">Physical Task</option>
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
      var find_project_url = "{{route('admin_find_task')}}";
      var token = "{{Session::token()}}";

      $(".archive").click(function(){
        var task_id = $(this).val();
        $("#statusProjectId").val(task_id);

      });

      $(".upload").click(function(){
        var task_id = $(this).val();
        $("#task_list_id").val(task_id);

      });

       $(".delete").click(function(){
        var task_id = $(this).val();
        $("#deleteProjectId").val(task_id);

      });

      $(".assign").click(function(){
        var task_id = $(this).val();
        $("#assignTask").val(task_id);

      });

      $(".updateProject").click(function(){
          var task_id = $(this).val();
          $("#updateProjectId").val(task_id);
          $.ajax({
           type:'POST',
           url:find_project_url,
           data:{_token: token, task_id : task_id},
           success:function(data) {
              console.log(data);
              $("#editTitle").val(data.title);
              $("#editDescription").val(data.description);
              $("#deadline_get").val(data.deadline);
              
           }
        });


      });

      $("#arrangeSelect").change(function(){
        var arrange = $(this).val();
        $("#arrangeForm").submit();
      });

    });
  </script>
</body>

</html>