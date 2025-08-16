<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('bootstrap-5.0.2-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('style.css')}}">
</head>
<body>
    <nav class="d-flex justify-content-around bg-dark text-white">
        <h1>StoryStack</h1>
        <div class="d-flex justify-content-end gap-3 align-items-center">
            <a href="{{route('login')}}" class="btn btn-primary">Login</a>
            <a href="{{route('register')}}" class="btn btn-primary">Signup</a>
        </div>
    </nav>
    
    <div class="container">
         <div class="row">
             <div class="col-8">
                 
                 @if (session('message')){{--iska matalb agar hamne koi message naam se key banayi hai jo kisi dusre page se arahi hai. yahan hamne controller ki file me store method me redirect krte waqt ek key banayi thi jis me user add hone message tha to ham usko yahan show karenge--}}
                     <div class="alert alert-success">{{session('message')}}</div>{{--ab user add hone par alert me hamara message show hojayega. or page refresh karne par message hat jayega--}}
                 @endif
             </div>
         </div>



        @php
            //$serial = 1;//lekin pagination me ye dusre page me ye dusre page me dubara 1 se start ho jaega isi liye ham firstitem()// method lagate hn
            if($posts->firstitem()){
            $serial = $posts->firstitem();//$users variable controller se send kiya hai
            //firstItem() batata hai current page ka pehla record actual position ke hisaab se.
            // Agar hum sirf $loop->iteration use karte to har page me numbering firse 1 se shuru hoti, lekin firstItem() global numbering deta hai.
            }else{
            $serial = 1;
            }
        @endphp
        @foreach ($posts as $post)

        <div class="mt-5 p-3" style="background-color: rgb(234, 234, 155)">
            <div class="my-2 d-flex justify-content-around"
                style="background-color: rgb(218, 218, 128); align-items: center">
                <div>
                    <h1>Post no. {{$serial++}}</h1>
                    <h2>{{$post->title}}</h2>
                    <h2>category: {{$post->category}}</h2>
                    <h2>Author: {{$post->users->name}}</h2>
                </div>
                <div>
                    <div>
                        <img src="{{asset('/storage/'.$post->image)}}" alt="" width="200px" height="200px">
                    </div>
                </div>

            </div>
            <p>{{$post->description}}</p>
            <button class="btn text-white login-first" style="background-color: rgb(168, 164, 164)" data-id = {{$post->id}}>comment</button>
            <p class="text-danger d-none no-error" id="ask-login{{$post->id}}" >you must login to comment on this post</p>
        </div>
        @endforeach

        <div class="mt-4 mb-5">
            {{$posts->links()}}{{--ye method pagination k liye use hota hai--}}
        </div>


    </div>

    <script>
        let commentButton = document.querySelectorAll('.login-first');//document.querySelectorAll('.login-first') ek NodeList return karta hai (array-like object), 
        commentButton.forEach(Button => {//isi liye loop me event lagana parta hai
            Button.addEventListener('click',function(){
                let id = Button.getAttribute('data-id');
                
                let no_error = document.querySelectorAll('.no-error');
                no_error.forEach(noerr => {
                    noerr.classList.add('d-none');
                });    
                document.querySelector(`#ask-login${id}`).classList.remove('d-none');//jis par click hua sirf uski class remove hogi baki sab par ye class add hojayegi           
            })
        });
       
    </script>
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