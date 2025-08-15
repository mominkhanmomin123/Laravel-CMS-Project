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

                        <input type="hidden" name="url" value="myposts">{{--ye ham redirect k waqt use karna hai takay redirect ushi page par ho--}}
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
    {{--modal close--}}


 
    


    {{-- <div class="row">
        <div class="col-8">

            @if (session('message')){{--iska matalb agar hamne koi message naam se key banayi hai jo kisi dusre page se
            arahi hai. yahan hamne controller ki file me store method me redirect krte waqt ek key banayi thi jis me
            user add hone message tha to ham usko yahan show karenge
            <div class="alert alert-success">{{session('message')}}</div>ab user add hone par alert me hamara message
            show hojayega. or page refresh karne par message hat jayega
            @endif
        </div>
    </div> --}}
    <div class="container">
           <h1>My posts</h1>
            <a href="{{route('userpostcreate')}}" class="btn btn-danger">Add post</a>
            @if (session('message'))
                <div class="row">
                    <div class="col">
                        <p class="alert alert-success">{{session('message')}}</p>
                    </div>
                </div>
            @endif


    @if ($posts->count()>0)
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
            <div class="d-flex gap-2">
                <button class="btn btn-warning btn-update" id="" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="{{$post->id}}" data-title="{{$post->title}}" data-image="{{$post->image}}" data-description="{{$post->description}}" data-category="{{$post->category}}" data-author="{{$post->users->name}}">
                Edit
            </button>
            <form action="{{route('post.destroy',$post->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" id="{{$post->id}}">Delete</button>
            </form>
            </div>
            
        </div>
        @endforeach

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
    }
</script>

    {{--reopen modal if error in update form--}}
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

        var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
        updateModal.show();
         localStorage.removeItem('openmodal');
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

     @else
      <h1>You have not post anything</h1>
  @endif 

    @include('pages/footer')