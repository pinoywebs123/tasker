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
        <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</span>
        <br />
        <span class="ms-1 font-weight-bold">{{Auth::user()->department->name}}</span>
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
              <h6>Users Table</h6>
              <button class="btn btn-info btn-xs edit" data-bs-toggle="modal" data-bs-target="#createModal">Create</button>
              @include('shared.notification')
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Staff Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Function</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Username</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Position</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Department</th>
                     
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users as $user)
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                          <p class="text-xs text-secondary mb-0">{{$user->first_name}} {{$user->last_name}}</p>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{strtoupper($user->getRoleNames()[0])}}</p>
                        
                      </td>
                       <td>
                        <p class="text-xs font-weight-bold mb-0">{{$user->username}}</p>
                        
                      </td>
                      
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-primary" style="width: 150px">{{$user->position->name}}</span>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-info" style="width: 300px">{{$user->department->name}}</span>
                      </td>
                     
                      <td class="align-middle">
                        <button class="btn btn-info btn-xs edit" data-bs-toggle="modal" data-bs-target="#editModal" value="{{$user->id}}">Edit</button>
                        <button class="btn btn-danger btn-xs archive" value="{{$user->id}}" data-bs-toggle="modal" data-bs-target="#deleteModal" value="{{$user->id}}">Delete</button>
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

  <div class="modal" id="editModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">User Informations</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form role="form" action="{{route('admin_update_user')}}" method="POST">
        <!-- Modal body -->
        <div class="modal-body">
           
                  @csrf
                  <input type="hidden" name="user_id" id="user_id">
                  <div class="mb-3">
                    <input type="text" class="form-control" placeholder="First Name" aria-label="Name" name="first_name" required id="firstName2">
                  </div>
                  <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Last Name" aria-label="Name" name="last_name" required id="lastName2">
                  </div>
                  <div class="mb-3">
                    <input type="email" class="form-control email_create" placeholder="Email" aria-label="Email" name="email" required id="email">
                  </div>


                  <div class="mb-3">
                    <label>Select Position</label>
                    <select class="form-control" name="position" required id="position">
                      @foreach($positions as $post)
                        <option value="{{$post->id}}">{{$post->name}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="mb-3">
                    <label>Select Department</label>
                    <select class="form-control" name="department" required id="department">
                       @foreach($departments as $dept)
                        <option value="{{$dept->id}}">{{$dept->name}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Password" aria-label="Password" name="password">
                  </div>
                  
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Submit</button>
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

<div class="modal" id="createModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">User Informations</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form role="form" action="{{route('register')}}" method="POST">
        <!-- Modal body -->
        <div class="modal-body">
           
                  @csrf
                  
                  <div class="mb-3">
                    <input type="text" class="form-control" placeholder="First Name" aria-label="Name" name="first_name" required id="firstName1">
                  </div>
                  <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Last Name" aria-label="Name" name="last_name" required id="lastName1">
                  </div>
                  <div class="mb-3">
                    <input type="email" class="form-control email_create" placeholder="Email" aria-label="Email" name="email" required id="email">
                  </div>

                  


                  <div class="mb-3">
                    <label>Select Department</label>
                    <select class="form-control" name="department" required id="department_create">
                      <option value="0"></option>
                       @foreach($departments as $dept)
                        <option value="{{$dept->id}}">{{$dept->name}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="mb-3">
                    <label>Select Position</label>
                    <select class="form-control" name="position" required id="position_create">
                      
                    </select>
                  </div>

                  <div class="mb-3">
                    <label>Select User Type</label>
                    <input type="hidden" name="user_type" id="user_type_create_value">
                    <p id="user_type_create" style="margin-left: 10px;"></p>
                  </div>

                  

                  <div class="mb-3">
                    <label>Password</label>
                    <input type="password" class="form-control" placeholder="Password" aria-label="Password" name="password">
                  </div>

                  <div class="mb-3">
                    <label>Repeat Password</label>
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
      var find_user_url = "{{route('admin_find_user')}}"; 
      var token = "{{Session::token()}}";
      $(".edit").click(function(){
        var user_id = $(this).val();
        $.ajax({
           type:'POST',
           url:find_user_url,
           data:{_token: token, user_id : user_id},
           success:function(data) {
              console.log(data);
              $("#firstName2").val(data.first_name);
              $("#lastName2").val(data.last_name);
              $("#email").val(data.email);
              $("#position").val(data.position_id);
              $("#department").val(data.department_id);
              $("#user_id").val(user_id);
           }
        });

      });

      $(".archive").click(function(){
          var user_id = $(this).val();
          $("#delete_user_id").val(user_id);
      });

      var department_create_url = "{{route('admin_department_create')}}";

      $("#department_create").change(function(){
        var department_id = $(this).val();

        $.ajax({
           type:'POST',
           url:department_create_url,
           data:{_token: token, department_id : department_id},
           success:function(data) {
              $("#position_create").empty();
              console.log(data);
              $('#position_create').append('<option></option>');
              $.each(data, function (i, item) {
                  $('#position_create').append($('<option>', { 
                      value: item.position_id,
                      text : item.position_name 
                  }));
                  console.log(item.position_name);
              });
             
           }
        });
        
      });

      var position_create_url = "{{route('admin_position_create')}}";

      $("#position_create").change(function(){
        var position_id = $(this).val();
        var department_id = $('#department_create').val();
       
       $.ajax({
           type:'POST',
           url:position_create_url,
           data:{_token: token, position_id : position_id, department_id: department_id},
           success:function(data) {
              $("#user_type_create").empty();
              console.log(data);
              
              $("#user_type_create").text(data.role_name);
              $("#user_type_create_value").val(data.role_id);
             
           }
        });

         
      });

      $(".email_create").focusout(function(){

        var myemail = $(this).val();
        

        if (!/@su.edu.ph\s*$/.test(myemail)) {
           console.log("Email need an offcial @su.edu.ph");
           $(".submit_user").attr("disabled", "disabled")

        }else {
          $(".submit_user").removeAttr("disabled");
        }
      });

    });

    function testInput(event) {
       var value = String.fromCharCode(event.which);
       var pattern = new RegExp(/[a-zåäö ]/i);
       return pattern.test(value);
    }

    $('#firstName1').bind('keypress', testInput);
    $('#lastName1').bind('keypress', testInput);

    $('#firstName2').bind('keypress', testInput);
    $('#lastName2').bind('keypress', testInput);

  </script>
</body>

</html>