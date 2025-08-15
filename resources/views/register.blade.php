<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('bootstrap-5.0.2-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
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
    <nav class="bg-dark text-white d-flex mb-0 align-items-center justify-content-around py-2">
        <h4 class="">StoryStack</h4>
        <a class="text-white" href="{{route('homepage')}}">Remain guest</a>        
    </nav>
    <div class="form-container">
        <h1 class="title"></h1><br>
        <script>
            let heading = localStorage.getItem("current_role");
            if(heading === "admin"){
                document.querySelector('.title').innerHTML = "Create user";
            }else{
                document.querySelector('.title').innerHTML = "Register yourself";
            }
        </script>
        @if (Auth::user())
            <form action="{{route('user.store')}}" method="POST">
        @else
            <form action="{{route('userstore')}}" method="POST">
        @endif
        
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">name</label>
                <input type="text" class="form-control" id="name" name="username" value="{{old('username')}}">
                <span class="text-danger">
                    @error('username'){{--error ek method hai jis me ham apni input field ka name pass krte hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation hamne UserController.php di hai agar user uski khilaf warzi kare--}}  
                        {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}                 
                    @enderror
                </span>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">email</label>
                <input type="email" class="form-control" id="email" name="useremail" value="{{old('useremail')}}">
                <span class="text-danger">
                    @error('useremail'){{--error ek method hai jis me ham apni input field ka name pass krte hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation hamne UserController.php di hai agar user uski khilaf warzi kare--}}  
                        {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}                 
                    @enderror
                </span>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">age</label>
                <input type="text" class="form-control" id="age" name="userage" value="{{old('userage')}}">
                <span class="text-danger">
                    @error('userage'){{--error ek method hai jis me ham apni input field ka name pass krte hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation hamne UserController.php di hai agar user uski khilaf warzi kare--}}  
                        {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}                 
                    @enderror
                </span>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">city</label>
                <select name="usercity" id="city" class="form-select">
                    <option value="{{old('usercity')}}" >{{old('usercity')}}</option>
                    <option value="karachi">karachi</option>
                    <option value="lahore">lahore</option>
                    <option value="islamabad">islamabad</option>
                    <option value="quetta">quetta</option>
                    <option value="peshawar">peshawar</option>
                </select>
                <span class="text-danger">
                    @error('usercity'){{--error ek method hai jis me ham apni input field ka name pass krte hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation hamne UserController.php di hai agar user uski khilaf warzi kare--}}  
                        {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}                 
                    @enderror
                </span>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">User role</label>
                <select name="userrole" id="role" class="form-select">
                    <option value="{{old('userrole')}}" >{{old('userrole')}}</option>
                    <option value="admin">admin</option>
                    <option value="user">user</option>
                </select>
                <span class="text-danger">
                    @error('userrole'){{--error ek method hai jis me ham apni input field ka name pass krte hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation hamne UserController.php di hai agar user uski khilaf warzi kare--}}  
                        {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}                 
                    @enderror
                </span>
            </div>

            <div class="mb-3" id="admin-code-container">{{--d-none isi liye diya takay agar user role admin hoga tab ye class remove hojayegi or ye code field open hojayegi javascript ki help se--}}
                <label for="admin-code" class="form-label">Admin code</label>
                <div class="d-flex align-items-center">
                    <input type="password" class="form-control" id="admin-code" name="password" value="{{old('password')}}">
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
                    <input type="password" class="form-control outline" id="password" name="userpassword" value="{{old('userpassword')}}">
                    <span><i class="bi bi-eye-fill" id="passicon"></i></span>
                </div>
                
                <span class="text-danger">
                    @error('userpassword'){{--error ek method hai jis me ham apni input field ka name pass krte hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation hamne UserController.php di hai agar user uski khilaf warzi kare--}}  
                        {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}                 
                    @enderror
                </span>
            </div>
            <div class="mb-3">
                <label for="confirmpassword" class="form-label">confirmpassword</label>
                <div class="d-flex align-items-center">
                    <input type="password" class="form-control" id="confirmpassword" name="userpassword_confirmation" value="{{old('userpassword_confirmation')}}">{{--bilkul yahi naam rakhna hai--}}
                     <span><i class="bi bi-eye-fill" id="pass2icon"></i></span>
                </div>
                <span class="text-danger">
                    @error('userpassword_confirmation'){{--error ek method hai jis me ham apni input field ka name pass krte hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation hamne UserController.php di hai agar user uski khilaf warzi kare--}}  
                        {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}                 
                    @enderror
                </span>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <div class="mt-3">
            <a class="text-primary" href="{{route('login')}}">already have an account? login</a>
        </div>
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
    
      let userrole = document.querySelector('#role');
      let admincontainer = document.querySelector('#admin-code-container');
      let admininput = document.querySelector('#admin-code');

      userrole.addEventListener('change',function(){
        if(this.value === 'user'){
            admincontainer.classList.add('d-none');
        }else{
            admincontainer.classList.remove('d-none');

            admininput.value = "";//user ne change kiya to value reset hojayegi
        }
      })
    </script>
</main>
@include('pages/footer')
    
    <script src="{{asset('bootstrap-5.0.2-dist/js/bootstrap.min.js')}}"></script>
</body>
</html>