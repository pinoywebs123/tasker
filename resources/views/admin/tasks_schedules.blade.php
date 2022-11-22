<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
 <script src="{{URL::to('gant/frappe-gantt.min.js')}}"></script>
  <link rel="stylesheet" href="{{URL::to('gant/frappe-gantt.css')}}">
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
                  <a class="nav-link " href="{{route('admin_task_list',Request::segment(2))}}">Task List</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link " href="{{route('admin_task_file_list',Request::segment(2))}}">Report Files</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="{{route('admin_task_schedule_list',Request::segment(2))}}">Report Schedule</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('admin_task_timeline_list',Request::segment(2))}}">Report Timeline</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Report Calendar</a>
                </li>
                
              </ul>
              <br>
              
             
              
              <h3 class="text-center">{{$find_assign_project->project->project_type}} to {{isset($find_assign_project->department->name) ? 'Report of '.$find_assign_project->department->name : 'None'}}</h3>
              
              @include('shared.notification')
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <h2 class="text-center">Interactive Gantt Chart</h2>
                <div class="gantt-target"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      
    </div>
  </main>
  




  
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
  <script>
    var tasks = [

      @foreach($tasks as $task)
        {
        start: '{{Carbon\Carbon::parse($task->created_at)->format("Y-m-d")}}',
        end: '{{$task->deadline}}',
        name: '{{$task->title}}',
        id: "{{$task->id}}"
      },

       @foreach($task->sub as $sub)
        {
        start: '{{Carbon\Carbon::parse($sub->created_at)->format("Y-m-d")}}',
        end: '{{$sub->deadline}}',
        name: '{{$sub->title}}',
        id: "{{$sub->id}}",
        dependencies: '{{$sub->task_id}}'
      },
       @endforeach

      @endforeach
      
     
    ]
    var gantt_chart = new Gantt(".gantt-target", tasks, {
      on_click: function (task) {
        console.log(task);
      },
      on_date_change: function(task, start, end) {
        console.log(task, start, end);
      },
      on_progress_change: function(task, progress) {
        console.log(task, progress);
      },
      on_view_change: function(mode) {
        console.log(mode);
      },
      view_mode: 'Month',
      language: 'en'
    });
    console.log(gantt_chart);
  </script>
</body>

</html>