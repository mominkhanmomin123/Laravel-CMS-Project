@include('pages/header')

    {{--comment modal--}}
@if (session('commentmodal') && isset($postpic) && isset($comments))
    
    <div class="modal fade" id="commentmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-body">
        
            <h3>{{$comments->count()}} comments</h3>

                <div>
                    <img src="{{asset('/storage/'.$postpic->image)}}" alt="" width="150px" height="150px">
                </div>
                    @if(session('message'))
                        <div class="alert alert-success">{{session('message')}}</div>      
                    @endif
                    <div class="text-danger">
                        @error('edit_comment_field'){{--error ek method hai jis me ham apni input field ka name pass krte hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation hamne UserController.php di hai agar user uski khilaf warzi kare--}}  
                            {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}                 
                        @enderror
                    </div>
            
           
             @foreach ($comments as $comment)
             
             <div class="comment-container">
                <div class="comment-box">
                     <div class="fw-bold">{{$comment->comment_by}}</div>
                    <div>{{$comment->comment}}</div>
                </div>
                @if (Auth::user()->id === $comment->userid)
                <div class="d-flex">
                    <p class="edit-button ms-2" id="edit-comment-button{{$comment->id}}" data-id="{{$comment->id}}" style="cursor: pointer"><i class="bi bi-pencil"></i></p>
                    <form action="{{route('usercommentdestroy', $comment->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="postid" value="{{$comment->postid}}">
                        <button type="submit" style="border: none; padding: 0%; height: 0px; margin-left:4px"><i class="bi bi-trash3"></i></button>
                    </form>
                </div>                   
               
                <form action="{{route("usercommentupdate", $comment->id)}}" method="POST">
                    @method('PUT')
                    @csrf
                    <div id="comment-container-close" class="d-none edit-comment-container{{$comment->id}}">
                    <input type="hidden" name="post_id" value="{{$comment->postid}}">
                    <textarea name="edit_comment_field" id="edit-comment{{$comment->id}}" rows="3" class="form-control edit-comment-close" >{{$comment->comment}}</textarea>
                    
                    <button type="submit" class="btn-sm btn-primary">update</button>
                    </div>
                </form>
                @endif 
                
                
                
                <p class="ps-2">{{$comment->created_at->diffForHumans()}}</p>{{--2min ago, 2hours ago--}}
             </div>
            
                          
             @endforeach
          
      </div>
      <script>

        let editbuttons = document.querySelectorAll('.edit-button');//sab class ko select karliya
        editbuttons.forEach(editbutton => {//isne node return kiya isi liye foreach lagaya hai
            editbutton.addEventListener('click', function(){//matlab ksi bhi class par click karen to
                comment_id = this.getAttribute('data-id');//dono class ki alag alag attribute value hai
                let edit_comment = document.querySelector(`.edit-comment-container${comment_id}`);
                edit_comment.classList.toggle('d-none');
            })
        });

     
                    
    </script>
      <div class="modal-footer d-block">
        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">add comment</label>
            <form action="{{route('usercommentstore')}}" method="POST">
            @csrf
            <input type="hidden" id="id" name="id" value="{{$postpic->id}}">
            <div class="write-comment d-flex gap-2 flex-wrap">
                <input type="text" class="form-control" id="recipient-name" name="comment" value="{{old('comment')}}" style="width: 70%">
                
                <button class="btn rounded-circle btn-primary" type="submit"><i class="bi bi-send-fill"></i></button>
            </div>
            <span class="text-danger">
                @error('comment')
                {{$message}}
                @enderror
            </span>
        </div>
            
        </form>
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close">Close</button>
        {{--sabse neeche javascript me mene dismiss listener lagaya hai jis me hamara localstorage remove hoga or ye homepage par redirect hojaega--}}
        
      </div>
    </div>
  </div>
</div>
{{-- <script>
    document.querySelector('#close-modal').addEventListener('click',function(){
        localStorage.removeItem("commentmodal");  // remove hone ke liye yaha likhna zaroori hai taakay dubara modal reopen na ho
       window.location.href = "/homepage";
    })
</script> --}}
    
@endif




    <div class="container">

        <h1>Users posts</h1>
    <a href="{{route('userpostcreate')}}" class="btn btn-danger">add post</a>
    <a href="{{route('myposts')}}" class="btn btn-danger">My posts</a>
    @if (session('message'))
        <div class="row">
            <div class="col">
                <p class="alert alert-success">{{session('message')}}</p>
            </div>
        </div>
    @endif

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
            <div class="d-flex justify-content-between align-items-end">
                <a href="{{route('userscommentsshow',$post->id)}}" class="btn text-white" style="background-color: black">See all Comments</a>
                <p class="mb-0">{{$post->created_at->diffForHumans()}}</p>
            </div>
            
        </div>
        @endforeach

       
        <div class="mt-4 mb-5">
            {{$posts->links()}}{{--ye method pagination k liye use hota hai--}}
        </div>







    </div>

    <script>
         //open singal post view modal. ye sara code bootstrap se liya hai lekin changes kari hn
        const commentmodal = document.getElementById('commentmodal');//apne modal ki id get kari hai
        if (commentmodal) {
        commentmodal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const commentbutton = event.relatedTarget;
            if(commentbutton){//agar viewbutton par click ho           
            //viewbutton se attributes ki value lenge
            let id= commentbutton.getAttribute('data-id');
            
            document.querySelector('#id').value = id;
            // document.querySelector('#post-image').src = `/storage/${image}`;
            // document.querySelector('#post-description').innerHTML = description;
            // document.querySelector('#post-author').innerHTML = username;
            

            }       
        })
    }
    </script>


{{-- //reopen comment modal --}}

@if (session('commentmodal') == 'commentmodal'){{--agar update modal me error ayega to ye session create hojayega or hamare local stprage me value set hojaegi--}}
    <script>
        localStorage.setItem("commentmodal","commentmodal");
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded',function(){
        let commentmodal = localStorage.getItem('commentmodal');
        if(commentmodal === 'commentmodal'){
            var commentModal = new bootstrap.Modal(document.getElementById('commentmodal'));
            commentModal.show();
           
        }
    })

  

</script>

{{--user update modal--}}
{{-- //reopen modal --}}
<script>

document.addEventListener("DOMContentLoaded", function(){
      //matlab agar comment modal dismiss ho ya backdrop ho to ye event call hoga
document.getElementById('commentmodal').addEventListener('hidden.bs.modal', function () {
    localStorage.removeItem("commentmodal");
    window.location.href = "/homepage";
});
})

     
</script>

@include('pages/footer')