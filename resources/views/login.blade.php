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
        <h1>Login</h1><br>
        <form action="{{route('logincheck')}}" method="POST">
            
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}">
                <span class="text-danger">
                    @error('email'){{--error ek method hai jis me ham apni input field ka name pass krte hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation hamne UserController.php di hai agar user uski khilaf warzi kare--}}  
                        {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}                 
                    @enderror
                </span>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">password</label>
                <input type="password" class="form-control" id="password" name="password">
                <span class="text-danger">
                    @error('password'){{--error ek method hai jis me ham apni input field ka name pass krte hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation hamne UserController.php di hai agar user uski khilaf warzi kare--}}  
                        {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}                 
                    @enderror
                </span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-primary">Login</button>
                <a href="{{route('register')}}" class="text-danger me-5" style="font-size: 14px">Don't have an account? Resister yourself!</a>
            </div>
            
        </form><br>
       
        <div class="row">
            <div class="col-8">
                
                @if (session('message')){{--iska matalb agar hamne koi message naam se key banayi hai jo kisi dusre page se arahi hai. yahan hamne controller ki file me store method me redirect krte waqt ek key banayi thi jis me user add hone message tha to ham usko yahan show karenge--}}
                    <div class="alert alert-danger">{{session('message')}}</div>{{--ab user add hone par alert me hamara message show hojayega. or page refresh karne par message hat jayega--}}
                @endif
                @if (session('message2')){{--iska matalb agar hamne koi message2 naam se key banayi hai jo kisi dusre page se arahi hai. yahan hamne controller ki file me store method me redirect krte waqt ek key banayi thi jis me user add hone message tha to ham usko yahan show karenge--}}
                    <div class="alert alert-success">{{session('message2')}}</div>{{--ab user add hone par alert me hamara message show hojayega. or page refresh karne par message hat jayega--}}
                @endif
            </div>
         </div>
    </div> 
    </main>
   <!-- Footer -->
 <footer class="text-center text-white py-2 bg-dark">
    <!-- Copyright -->
    <div class="text-center p-3 bg-dark">
      © 2025 Copyright:
      <a class="text-white" href="https://mdbootstrap.com/">StoryStack.com</a>
    </div>
    <!-- Grid container -->
  </footer>
  <!-- Footer -->
  
    <script src="{{asset('bootstrap-5.0.2-dist/js/bootstrap.min.js')}}"></script>
</body>
</html>