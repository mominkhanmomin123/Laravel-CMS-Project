@include('pages/header')

    <div class="container">
        <h1>Admin Dashboard</h1>
        <a href="{{route('user.index')}}" class="btn btn-primary">All users</a>
        <a href="{{route('post.index')}}" class="btn btn-primary">All posts</a>
        <a href="" class="btn btn-primary">All comments</a>
    </div>
</main>
   
    @include('pages/footer')