<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title><link rel="stylesheet" href="{{asset('bootstrap-5.0.2-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
     <style>
         html, body {
      height: 100%;
      margin: 0;
    }
    body {
      display: flex;
      flex-direction: column;
    }
    main {
      flex: 1;
      /* ka matlab hai content middle part ko fill kare, footer hamesha neeche push ho. sara content ham is me likhenge */
    }
    /*matlab agar page me content kam ho to footer browser ke bottom me chipka rahe,
aur agar content zyada ho to naturally scroll ke end me aa jaye. uske liye tumhe footer ko "sticky footer" logic dena hoga */
    </style>
</head>

<body>
    <main>
    
    @if(session('current_user'))
    <script>
        localStorage.setItem('current_user', "{{ session('current_user') }}");
    </script>
    @endif
    @if(session('current_role'))
    <script>
        localStorage.setItem('current_role', "{{ session('current_role') }}");
    </script>
    @endif
    @if(session('current_user_id'))
    <script>
        localStorage.setItem('current_user_id', "{{ session('current_user_id') }}");
    </script>
    @endif
    @if (session('userupdatemodal'))
    <script>
        localStorage.setItem('userupdatemodal', "{{session('userupdatemodal')}}");
    </script>
    @elseif(!session('userupdatemodal'))
    <script>
        localStorage.removeItem('userupdatemodal');
    </script>
    @endif


      {{--view user modal--}}
    <div class="modal fade" id="viewuserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">             
                <div id="modal-view-body" class="container py-3">
                    <h1 class="bg-primary" id="post-title">Your details</h1>
                    
                    
                    <h4 id="">User id: {{Auth::user()->id}}</h4><hr>
                    <h4 id="">User name: {{Auth::user()->name}}</h4><hr>
                    <h4 id="">User email: {{Auth::user()->email}}</h4><hr>
                    <h4 id="">User age: {{Auth::user()->age}}</h4><hr>
                    <h4 id="">User city: {{Auth::user()->city}}</h4><hr>
                    <h4 id="">User role: {{Auth::user()->role}}</h4>
                   
                    

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>


      {{--delete user modal--}}
    <div class="modal fade" id="deleteusermodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">             
                <div id="modal-delete-body" class="container py-3">
                   <h3 class="text-center">Are you sure!</h3>
                    <h5 class="text-center"> You want to delete your account</h5>
                </div>
                <div class="modal-footer">
                     <form action="{{route('userdestroy', Auth::user()->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="logout()" >delete</button>
                        </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>

            </div>
        </div>
    </div>

    {{--user update modal--}}

    <div class="modal fade" id="userupdatemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('userupdate', Auth::user()->id)}}" method="POST">
                    @method('PUT'){{--HTML form POST send karega par Laravel ko pata chalega ki ye PUT request hai (jo
                    update() method handle karta hai).--}}
                    @csrf
                    <div id="modal-update-body" class="container py-3">
                        <h1 class="bg-primary">Update user <span id="inputid"></span></h1>

                        <input type="hidden" name="id" id="id" value="{{Auth::user()->id}}">{{--isme ham post ki id pass krege jo update krte waqt
                        kam ayegi --}}
                        <div class="mb-3">
                            <label for="name" class="form-label" id="name-label">name</label>
                            <input type="text" class="form-control" id="name" name="username"
                                value="{{old('username', Auth::user()->name)}}">
                            <span class="text-danger">
                                @error('username'){{--error ek method hai jis me ham apni input field ka name pass krte
                                hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation
                                hamne UserController.php di hai agar user uski khilaf warzi kare--}}
                                {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">email</label>
                            <input type="email" class="form-control" id="email" name="useremail"
                                value="{{old('email', Auth::user()->email)}}">
                            <span class="text-danger">
                                @error('useremail'){{--error ek method hai jis me ham apni input field ka name pass krte
                                hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation
                                hamne UserController.php di hai agar user uski khilaf warzi kare--}}
                                {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">age</label>
                            <input type="text" class="form-control" id="age" name="userage" value="{{old('age', Auth::user()->age)}}">
                            <span class="text-danger">
                                @error('userage'){{--error ek method hai jis me ham apni input field ka name pass krte
                                hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation
                                hamne UserController.php di hai agar user uski khilaf warzi kare--}}
                                {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">city</label>
                            <select name="usercity" id="city" class="form-select">
                                <option value="{{old('city', Auth::user()->city)}}">{{old('city', Auth::user()->city)}}</option>
                                <option value="karachi">karachi</option>
                                <option value="lahore">lahore</option>
                                <option value="islamabad">islamabad</option>
                                <option value="quetta">quetta</option>
                                <option value="peshawar">peshawar</option>
                            </select>
                            <span class="text-danger">
                                @error('usercity'){{--error ek method hai jis me ham apni input field ka name pass krte
                                hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation
                                hamne UserController.php di hai agar user uski khilaf warzi kare--}}
                                {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">User role</label>
                            <select name="userrole" id="role" class="form-select">
                                <option value="{{old('userrole', Auth::user()->role)}}">{{old('userrole', Auth::user()->role)}}</option>
                                <option value="admin">admin</option>
                                <option value="user">user</option>
                            </select>
                            <span class="text-danger">
                                @error('userrole'){{--error ek method hai jis me ham apni input field ka name pass krte
                                hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation
                                hamne UserController.php di hai agar user uski khilaf warzi kare--}}
                                {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3" id="admin-code-container">{{--d-none isi liye diya takay agar user role admin hoga tab ye class remove hojayegi or ye code field open hojayegi javascript ki help se--}}
                        <label for="admin-code" class="form-label">Admin code</label>
                        <div class="d-flex align-items-center">
                            <input type="password" class="form-control" id="admin-code" name="password" value="">
                            <span><i class="bi bi-eye-fill" id="codeicon"></i></span>
                        </div>
                        <span class="text-danger">
                            @error('password'){{--error ek method hai jis me ham apni input field ka name pass krte hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation hamne UserController.php di hai agar user uski khilaf warzi kare--}}  
                                {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}                 
                            @enderror
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">password</label>
                        <div class="d-flex align-items-center">
                            <input type="password" class="form-control outline" id="password" name="userpassword" value="">
                            <span><i class="bi bi-eye-fill" id="passicon"></i></span>
                        </div>
                        
                        <span class="text-danger">
                            @error('userpassword'){{--error ek method hai jis me ham apni input field ka name pass krte hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation hamne UserController.php di hai agar user uski khilaf warzi kare--}}  
                                {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}                 
                            @enderror
                        </span>
                    </div>
                    
                    <script>
                         //see password
                document.querySelector("#codeicon").addEventListener('click',function(){
                    let admincode = document.querySelector('#admin-code');
                    if(admincode.getAttribute('type') === 'password'){
                        admincode.setAttribute('type','text');
                    }else{
                        admincode.setAttribute('type','password');
                    }
                })
                document.querySelector("#passicon").addEventListener('click',function(){
                    let password = document.querySelector('#password');
                    if(password.getAttribute('type') === 'password'){
                        password.setAttribute('type','text');
                    }else{
                        password.setAttribute('type','password');
                    }
                })
                document.querySelector("#pass2icon").addEventListener('click',function(){
                    let cpassword = document.querySelector('#confirmpassword');
                    if(cpassword.getAttribute('type') === 'password'){
                        cpassword.setAttribute('type','text');
                    }else{
                        cpassword.setAttribute('type','password');
                    }
                })

            
                    </script>
                    

                    </div>
                    <button class="btn btn-primary" type="submit" id="updateuser">Update user</button>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close-modal">Close</button>

                </div>

            </div>
        </div>
    </div>

    {{-- <script>
    document.querySelector('#close-modal').addEventListener('click',function(){
        localStorage.removeItem("userupdatemodal");  // remove hone ke liye yaha likhna zaroori hai taakay dubara modal reopen na ho
    })

      </script> --}}


    <nav class="d-flex justify-content-around bg-dark text-white py-2">
        <h1>StoryStack</h1>
        <div class="d-flex justify-content-end gap-3 align-items-center">
            <a href="{{route('homepage')}}" class="btn btn-sm btn-danger">Home</a>            
          <a href="{{route('dashboard')}}" class="btn btn-sm btn-primary d-none" id="dashboard">dashboard</a>
            <div class="dropdown">
                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-fill"></i>
                </button>
                
                <ul class="dropdown-menu">
                    <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#viewuserModal">View profile</button></li>
                    <li><button class="dropdown-item"  data-bs-toggle="modal"  data-bs-target="#userupdatemodal">Edit profile</li>
                    <li>
                       <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteusermodal">Delete profile</button>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" id="form-logout">
                        @csrf
                            <button type="submit" class="btn btn-primary dropdown-item" onclick="logout()" style="border: none">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
            <script>
                //document.addEventListener('DOMContentLoaded', function(){
                    if(localStorage.getItem('current_role') === 'admin'){
                    let dashboard = document.querySelector('#dashboard');
                    dashboard.classList.remove('d-none');                 
                }
                //});
                
            </script>



        </div>
    </nav>
    <script>
        function logout(){//logout hone par dono keys localstorage se hat jayengi
            localStorage.removeItem('current_user_id');
            localStorage.removeItem('current_user');
            localStorage.removeItem('current_role');
            localStorage.removeItem('image_again');
            localStorage.removeItem('post_description');
        }
    </script>

    
   
<script>
document.addEventListener('DOMContentLoaded', function(){
    let userupdatemodal = localStorage.getItem('userupdatemodal');
    if(userupdatemodal == "userupdatemodal"){
        var updateModal = new bootstrap.Modal(document.getElementById('userupdatemodal'));
        updateModal.show();
    }
    
});
</script>


<script>
    document.addEventListener("DOMContentLoaded", function(){
    // Modal open hone ke baad run hoga Qk dom me ham direct nhi likh sakte
    document.getElementById('userupdatemodal').addEventListener('shown.bs.modal', function () {
        let userrole = document.querySelector('#role');
        let admincontainer = document.querySelector('#admin-code-container');
        let admininput = document.querySelector('#admin-code');

        // Initial state check
        if(userrole.value === 'user'){
            admincontainer.classList.add('d-none');
        } else {
            admincontainer.classList.remove('d-none');
        }

        // add & remove d-none class on Change 
        userrole.addEventListener('change', function(){
            if(this.value === 'user'){
                admincontainer.classList.add('d-none');
            } else {
                admincontainer.classList.remove('d-none');
                admininput.value = "";
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function(){
      //matlab agar comment modal dismiss ho ya backdrop ho to ye event call hoga
document.getElementById('userupdatemodal').addEventListener('hidden.bs.modal', function () {
    localStorage.removeItem("userupdatemodal");
    
});
})

</script> 


    
   




