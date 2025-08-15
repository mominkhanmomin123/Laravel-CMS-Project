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
</head>
<body>
    @include('pages/header')
    <a href="{{route('homepage')}}" class="btn btn-danger">Users post</a>
    <div class="form-container my-4">
        <h1>Add post</h1><br>
        @if (Auth::user()->role == "admin")
        <form action="{{route('post.store')}}" method="POST" enctype="multipart/form-data">
        @else
        <form action="{{route('userpoststore')}}" method="POST" enctype="multipart/form-data">
        @endif
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}" autocomplete="on">
                <span class="text-danger">
                    @error('title'){{--error ek method hai jis me ham apni input field ka name pass krte hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation hamne UserController.php di hai agar user uski khilaf warzi kare--}}  
                        {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}                 
                    @enderror
                </span>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">upload image</label>
                <input type="file" class="form-control" id="image" name="image" value="{{old('image')}}">
                <span class="text-danger">
                    @error('image'){{--error ek method hai jis me ham apni input field ka name pass krte hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation hamne UserController.php di hai agar user uski khilaf warzi kare--}}  
                        {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}                 
                    @enderror
                </span>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">description</label>
                <textarea type="text" class="form-control" id="description" name="description" rows="3" cols="12" autocomplete="on">{{old('description')}}</textarea>
                <span class="text-danger">
                    @error('description'){{--error ek method hai jis me ham apni input field ka name pass krte hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation hamne UserController.php di hai agar user uski khilaf warzi kare--}}  
                        {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}                 
                    @enderror
                </span>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">category</label>
                <select name="category" id="category" class="form-select">
                    <option value="{{old('category')}}" >{{old('category')}}</option>
                    <option value="Technology">Technology</option>
                    <option value="Education">Education</option>
                    <option value="Health & fitness">Health & fitness</option>
                    <option value="Entertainment">Entertainment</option>
                    <option value="Sports">Sports</option>
                    <option value="Bussiness & Finance">Bussiness & Finance</option>
                    <option value="News & politics">News & politics</option>
                    <option value="Lifestyle">Lifestyle</option>
                    <option value="Science">Science</option>
                    <option value="Events">Events</option>
                    <option value="Jobs & careers">Jobs & careers</option>
                    <option value="Others">Others</option>
                </select>
                <span class="text-danger">
                    @error('category'){{--error ek method hai jis me ham apni input field ka name pass krte hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation hamne UserController.php di hai agar user uski khilaf warzi kare--}}  
                        {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}                 
                    @enderror
                </span>
            </div>
            
            <button type="submit" class="btn btn-primary">Create post</button>
        </form>
    </div>

    
    <script>
        
    </script>
    
 @include('pages/footer')

</body>
</html>