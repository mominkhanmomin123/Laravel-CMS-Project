@include('pages/header')
<div class="container">
    @if ($single_user_posts->count() > 0)

   <h1>Author Name: {{$single_user_posts[0]->users->name}}</h1>


   @php
       $postno = 1;
   @endphp
   @foreach ($single_user_posts as $posts)
   
   <div class="mt-5 p-3" style="background-color: rgb(234, 234, 155)">
        <div class="my-2 d-flex justify-content-around" style="background-color: rgb(218, 218, 128); align-items: center">
            <div>
                <h1>Post no. {{$postno++}}</h1>
                <h2>{{$posts->title}}</h2>
                <h2>category: {{$posts->category}}</h2>
            </div>
            <div>
                <div>
                    <img src="{{asset('/storage/'.$posts->image)}}" alt="" width="200px" height="200px">
                </div>
            </div>
            
            </div>
        <p>{{$posts->description}}</p>
    </div>
   @endforeach

   @else
   <div class="fs-2">This user does not post anything</div>
 @endif






@include('pages/footer')