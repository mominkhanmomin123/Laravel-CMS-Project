@include('pages/header')

     

    <!--Single post update Modal -->
    <div class="modal fade" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST" id="" enctype="multipart/form-data">
                    @method('PUT'){{--HTML form POST send karega par Laravel ko pata chalega ki ye PUT request hai (jo update() method handle karta hai).--}}
                    @csrf
                    <div id="modal-update-body" class="container py-3">
                        <h1 class="bg-primary">Update <span id="update-post-title"></span></h1>

                        <input type="hidden" name="id" id="id" value="{{old('id')}}">{{--isme ham post ki id pass krege jo update krte waqt kam ayegi --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{old('title')}}">
                            <span class="text-danger">
                                @error('title'){{--error ek method hai jis me ham apni input field ka name pass krte
                                hn jis ka error show krwana ho. ye method automatic trigger hojata hai jo validation
                                hamne UserController.php di hai agar user uski khilaf warzi kare--}}
                                {{$message}}{{--wahi message print hoga jo validation.php file me rule ki value hai--}}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">image</label>
                            <input type="file" class="form-control" id="image" name="image">
                            <span class="text-danger">
                                @error('image')
                                {{$message}}
                                @enderror
                            </span>
                            <div>
                                <img src="" alt="" id="old-image" width="100px" height="100px">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" value="{{old('description')}}"></textarea>
                            <span class="text-danger">
                                @error('description')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">category</label>
                            <select name="category" id="category" class="form-select">
                                <option value="{{old('category')}}">{{old('category')}}</option>
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
                                @error('category')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        
                        

                        <div class="mb-3 d-none author-div">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" id="author" name="author" class="form-control" value="{{old('author')}}">
                            <span class="text-danger">
                                @error('author')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        
                       <script>
                        //hamne condition lagayi hai k agar role admin hoga tab hi wo author ka input boc dekh sakta hai ko edit kar sakta hai
                            if(localStorage.getItem('current_role') === 'admin'){
                                document.querySelector('.author-div').classList.remove('d-none');
                            }
                        </script>
                        


                    </div>
                    <button class="btn btn-primary" type="submit" id="updatepost">Update post</button>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="viewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">             
                <div id="modal-view-body" class="container py-3">
                    <h1 class="bg-primary" id="post-title">Post details</h1>
                    <div>
                        <img src="" alt="" id="post-image" width="300px" height="300px">
                    </div>
                    <p id="post-description">post d</p>
                    <p id="post-author">post a</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
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
                <div class="d-flex">
                    <p class="edit-button ms-2 mb-0" id="edit-comment-button{{$comment->id}}" data-id="{{$comment->id}}" style="cursor: pointer"><i class="bi bi-pencil"></i></p>
                    <form action="{{route('comment.destroy', $comment->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="postid" value="{{$comment->postid}}">
                        <button type="submit" style="border: none; padding: 0%; height: 0px; margin-left:4px; margin-bottom:0%"><i class="bi bi-trash3"></i></button>
                    </form>
                </div>                   
               
                <form action="{{route("comment.update", $comment->id)}}" method="POST">
                    @method('PUT')
                    @csrf
                    <div id="comment-container-close" class="d-none edit-comment-container{{$comment->id}}">
                    <input type="hidden" name="post_id" value="{{$comment->postid}}">
                    <textarea name="edit_comment_field" id="edit-comment{{$comment->id}}" rows="3" class="form-control edit-comment-close" >{{$comment->comment}}</textarea>
                    
                    <button type="submit" class="btn-sm btn-primary">update</button>
                    </div>
                </form>                              
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
            <form action="{{route('comment.store')}}" method="POST">
            @csrf
            <input type="hidden" id="id" name="id" value="{{$postpic->id}}">
            <input type="hidden" id="route" name="route" value="allpost">
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
        <button type="button" class="btn btn-secondary" id="close-modal" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

    
@endif

<div class="container">
    <h1>Posts detaits</h1>
    <h2></h2>
    <a href="{{route('post.create')}}" class="btn btn-primary">Add posts</a>
    <div class="row">
        <div class="col-8">
            @if(session('message'))
            <div class="alert alert-success">{{session('message')}}</div>
             @endif
        </div>
    </div>
   


    @if(session('current_user'))
    <script>
        localStorage.setItem('current_user', "{{ session('current_user') }}");
    </script>
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

    <table class="table table-bordered table-striped">
        <tr class="fs-5">
            <th class="align-content-center text-center">SNo.</th>
            <th class="align-content-center text-center">Id</th>
            <th class="align-content-center text-center">Title </th>
            <th class="align-content-center text-center">Image</th>
            <th class="align-content-center text-center">Description</th>
            <th class="align-content-center text-center">Category</th>
            <th class="align-content-center text-center">Author</th>
            <th class="align-content-center text-center">Comments</th>
            <th class="align-content-center text-center">View</th>
            <th class="align-content-center text-center">Update</th>
            <th class="align-content-center text-center">Delete</th>
        </tr>
        @foreach ($posts as $post)
        <tr class="text-center">
            <td class="align-content-center">{{$serial++}}</td>
            <td class="align-content-center">{{$post->id}}</td>
            <td class="align-content-center">{{$post->title}}</td>
            <td class="align-content-center"><img src='{{asset('/storage/'.$post->image)}}' alt="" width = "50px" height = "50px">
            </td>
            <td class="align-content-center description-td" style="width: 100%">{{$post->description}}</td>
            <td class="align-content-center">{{$post->category}}</td>
            <td class="align-content-center">{{$post->users->name}}</td>
            <td class="align-content-center"><a href="{{route('comment.show',$post->id)}}" class="btn btn-secondary">comments</button></a>         
            <td class="align-content-center"><button class="btn btn-warning btn-view" id="" data-bs-toggle="modal" data-bs-target="#viewModal"
                    data-id="{{$post->id}}" data-title="{{$post->title}}" data-image="{{$post->image}}"
                    data-description="{{$post->description}}" data-category="{{$post->category}}" data-username="{{$post->users->name}}">{{--ye hamare join table se value li hai--}}
                    View
                </button>
            </td>
            <td class="align-content-center"><button class="btn btn-warning btn-update" id="" data-bs-toggle="modal" data-bs-target="#updateModal"
                    data-id="{{$post->id}}" data-title="{{$post->title}}" data-image="{{$post->image}}"
                    data-description="{{$post->description}}" data-category="{{$post->category}}" data-author="{{$post->users->name}}">
                    Update
                </button>
            </td>
            <form action="{{route('post.destroy',$post->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <td class="align-content-center"><button type="submit" class="btn btn-danger" id="{{$post->id}}">Delete</button></td>
            </form>
        </tr>
        @endforeach
    </table>
    <div class="mt-4">
        {{$posts->links()}}{{--ye method pagination k liye use hota hai--}}
    </div>
    </div>

    <script>
       
        //open singal post update modal. ye sara code bootstrap se liya hai lekin changes kari hn
        const updateModal = document.getElementById('updateModal');//apne modal ki id get kari hai
        if (updateModal) {
        updateModal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const updatebutton = event.relatedTarget;
            if(updatebutton){//agar button par click ho           
            //button se attributes ki value lenge
            let id= updatebutton.getAttribute('data-id');
            let title= updatebutton.getAttribute('data-title');
            let image= updatebutton.getAttribute('data-image');
            let description= updatebutton.getAttribute('data-description');
            let category= updatebutton.getAttribute('data-category');
            let author= updatebutton.getAttribute('data-author');
            

            //in values ko apni input fields me set karenge
            // document.querySelector('#inputid').innerHTML = id;
            document.querySelector('#id').value = id;
            document.querySelector('#title').value = title;
            // document.querySelector('#image').value = image;
            document.querySelector('#description').value = description;
            document.querySelector('#category').value = category;
            document.querySelector('#author').value = author;

            localStorage.setItem('post_description',description);//description or image ki value localstoarage me save kari qk indono ki value refill nhi hoti hame localstorage se get karni parti hai
            localStorage.setItem('image_again',image);
            document.querySelector('#old-image').src = `/storage/${image}`;

            //agar new image user select kare to usja preview bhi is #old-image me dikhana hai
            let fileinput = document.querySelector('#image');
            fileinput.addEventListener('change',function(){//user file value change kare to
                const files = this.files[0];//.files ek file list hoti h. user ne jo files select ki hoti hn ye unka array hota hai. [0] Pehli file ko le raha hai (kyunki ek hi file select hoti hai normally).
                if (files) {//Check karta hai ki file actually choose hui hai ya nahi (agar user cancel kare to ye undefined ho sakti hai).
                    const reader = new FileReader();//FileReader() JavaScript ka built-in API hai jo local system me choose ki gayi file ko read karta hai (image, text, etc.) bina server par upload kiye. Phir us file ka base64 encoded data URL generate karta hai(e.g. data:image/png;base64,iVBORw0KG...). new FileReader() Iska ek naya instance/object create kiya hai jo file read karne ke liye use hoga.
                    reader.onload = function (e) {//onload ek event handler hai jo tab run hota hai jab file ka reading process complete ho jata hai.

                        //console.log(e.target.result);//data:image/jpeg;base64,9j4QDWRXhpZgAASUkqAAgAAAAGAB......
                        //data:image/png;base64, -> ye file ka type hai (png) aur ye batata hai ki ye base64 encoded data hai.
                        //9j4QDWRXhpZg.... -> ye encoded file ka content hai (pure image ko ek text string banake encode kiya gaya hai).
                        
                        document.querySelector('#old-image').src = e.target.result;//e.target.result file ka data URL return karta hai (base64 encoded string), jo image ka binary data hota hai.

                    }
                    reader.readAsDataURL(files);//readAsDataURL(file) → File ko base64 encoded string ke form me convert karta hai jo <img> ke src ke liye compatible hota hai.
                    //Iske baad jab file read ho jati hai to reader.onload trigger hota hai aur image preview update ho jata hai.
                }
            });
            

            //form action me iska route set karenge
            updateModal.querySelector('form').action = "{{ route('post.update', ':id') }}".replace(':id',id);//yahan document.querySelector nhi likha q k ye hamare document me exist nhi karta ye hamare model me exists krta hai. iska matlab neeche define kiya hai verbatim me taakay dollar ka sign dekh kar wo isko real variable consider karlega
            }
            else{//agar error k baad reopen hoga to id ki value yahan se milegi button se nhi milegi. hamne form fields me value=old diya hai isse purani value auto fill hojaegi
                let id = document.querySelector("#id").value;
                //form action me iska route set karenge
                updateModal.querySelector('form').action = "{{ route('post.update', ':id') }}".replace(':id',id);

            }       
        })
    }else{//agar error ayega update me to ham image ki value localstorage se lenge jo ham button se data lete waqt save kari thi qk input file ki value=old dubara refill nhi hoti baji inputs ki tarah
        // image_again = localStorage.getItem('image_again');
        // if(image_again){
        //     document.querySelector('#old-image').scr = `/storage/${image_again}`
        // }
    }
        //open singal post view modal. ye sara code bootstrap se liya hai lekin changes kari hn
        const viewModal = document.getElementById('viewModal');//apne modal ki id get kari hai
        if (viewModal) {
        viewModal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const viewbutton = event.relatedTarget;
            if(viewbutton){//agar viewbutton par click ho           
            //viewbutton se attributes ki value lenge
            let id= viewbutton.getAttribute('data-id');
            let title= viewbutton.getAttribute('data-title');
            let image= viewbutton.getAttribute('data-image');
            let description= viewbutton.getAttribute('data-description');
            let category= viewbutton.getAttribute('data-category');
            let username= viewbutton.getAttribute('data-username');
            
            document.querySelector('#post-title').innerHTML = title;
            document.querySelector('#post-image').src = `/storage/${image}`;
            document.querySelector('#post-description').innerHTML = description;
            document.querySelector('#post-author').innerHTML = username;
            

            }       
        })
    }
    </script>
    @verbatim
    <script>
        //updateModal.querySelector('form').action = "{{ route('user.update', ${id}) }}";agar ham is tarah likhte to
            //PHP ka route('user.update', ${id}) compile hone se pehle ${id} ko variable ke tarah read karega, lekin PHP ke pass id variable hai hi nahi (wo sirf JavaScript me hota hai).
           // Solution: Placeholder + Replace
            // Laravel se ek dummy URL generate karwa lo:

            // {{ route('user.update', ':id') }}
            // Ye URL aisa banega:

            // http://127.0.0.1:8000/user/:id
            // Phir JavaScript me runtime pe actual id inject kar do:

            // .replace(':id', id)
            // Is tarah ye route aesa hojaega:
            //http://127.0.0.1:8000/user/5

            // Laravel ka route helper sahi se compile hota hai.

            // JavaScript runtime pe dynamic id inject kar leta hai.

    </script>
    @endverbatim

    @if (session('openModal') == 'UpdateModal'){{--agar update modal me error ayega to ye session create hojayega or
    hamare local stprage me value set hojaegi--}}
    <script>
        localStorage.setItem("openmodal","updatemodal");
    </script>
    @endif

    <script>

        document.addEventListener("DOMContentLoaded", function() {//browser khulte hi ye code run hoga
    let openModal = localStorage.getItem("openmodal");
    if (openModal === "updatemodal") {//matlab agar localstorage ki value "updatemodal" hogi to iska matlab hamara session"openModal" create hua hoga to hamara model page refresh hote hi localstorage ki wajah se reopen ho jaye ga 
            localStorage.removeItem('openmodal');
           
        var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
        updateModal.show();
         
        //agar error ayega update me to ham image ki value localstorage se lenge jo ham button se data lete waqt save kari thi qk input file ki value=old dubara refill nhi hoti baji inputs ki tarah
        image_again = localStorage.getItem('image_again');
        if(image_again){
            document.querySelector('#old-image').src = `/storage/${image_again}`
        }
        //description ki value localstorage se lenge jo set kari thi
        description = localStorage.getItem('post_description');
        document.querySelector("#description").innerHTML=description;

         //agar new image user select kare to usja preview bhi is #old-image me dikhana hai
            let fileinput = document.querySelector('#image');
            fileinput.addEventListener('change',function(){//user file value change kare to
                const files = this.files[0];
                if (files) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        
                        document.querySelector('#old-image').src = e.target.result;

                    }
                    reader.readAsDataURL(files);
                }
            });

            //form ka action ham ne pehle hi set kia hua tha else me updatemodal me
            
            


    }
});
    </script>


{{-- //reopen comment modal --}}

@if (session('commentmodal') == 'commentmodal'){{--agar update modal me error ayega to ye session create hojayega or hamare local stprage me value set hojaegi--}}
    <script>
        localStorage.setItem("commentmodal","commentmodal");
    </script>

@elseif (!session('commentmodal'))
<script>
    localStorage.removeItem('commentmodal');
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

    document.addEventListener("DOMContentLoaded", function(){
      //matlab agar comment modal dismiss ho ya backdrop ho to ye event call hoga
        document.getElementById('commentmodal').addEventListener('hidden.bs.modal', function () {
            localStorage.removeItem("commentmodal");
            window.location.href = "/post";
        });
    })
</script>


  @include('pages/footer')