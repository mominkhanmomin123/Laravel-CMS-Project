@include('pages/header')


    <!--Single post update Modal -->
    <div class="modal fade" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    @method('PUT'){{--HTML form POST send karega par Laravel ko pata chalega ki ye PUT request hai (jo
                    update() method handle karta hai).--}}
                    @csrf
                    <div id="modal-update-body" class="container py-3">
                        <h1 class="bg-primary">Update user <span id="inputid"></span></h1>

                        <input type="hidden" name="id" id="id" value="{{old('id')}}">{{--isme ham post ki id pass krege jo update krte waqt
                        kam ayegi --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">name</label>
                            <input type="text" class="form-control" id="name" name="username"
                                value="{{old('username')}}">
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
                                value="{{old('useremail')}}">
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
                            <input type="text" class="form-control" id="age" name="userage" value="{{old('userage')}}">
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
                                <option value="{{old('usercity')}}">{{old('usercity')}}</option>
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
                                <option value="{{old('userrole')}}">{{old('userrole')}}</option>
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


                    </div>
                    <button class="btn btn-primary" type="submit" id="updatepost">Update post</button>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>

    <h1>Users detaits</h1>
    <a href="{{route('register')}}" class="btn btn-primary">Add user</a>
        <div class="row">
            <div class="col-8">
                @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            </div>
        </div>        
    @endif

    @php
        //$serial = 1;//lekin pagination me ye dusre page me ye dusre page me dubara 1 se start ho jaega isi liye ham firstitem() method lagate hn
        $serial = $users->firstitem();//$users variable controller se send kiya hai
        //firstItem() batata hai current page ka pehla record actual position ke hisaab se.
        // Agar hum sirf $loop->iteration use karte to har page me numbering firse 1 se shuru hoti, lekin firstItem() global numbering deta hai.
    @endphp
    <div class="container row">
        <div class="col-12">
            <table class="table border">
                <tr>
                    <th>S No.</th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>City</th>
                    <th>Role</th>
                    <th>Update</th>
                    <th>Delete</th>
                    <th>Posts</th>
                </tr>
                @foreach ($users as $user)
                <tr>
                    <td>{{$serial++}}</td>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->age}}</td>
                    <td>{{$user->city}}</td>
                    <td>{{$user->role}}</td>
                    <td><button class="btn btn-warning btn-update" id="" data-bs-toggle="modal"
                            data-bs-target="#updateModal" data-id="{{$user->id}}" data-name="{{$user->name}}"
                            data-email="{{$user->email}}" data-age="{{$user->age}}" data-city="{{$user->city}}"
                            data-role="{{$user->role}}">
                            Update
                        </button>
                    </td>
                    <form action="{{route('user.destroy',$user->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <td><button type="submit" class="btn btn-danger" id="{{$user->id}}">Delete</button></td>
                    </form>
                    <td><a href="{{route('user.show',$user->id)}}" class="btn btn-secondary" id="{{$user->id}}">Posts</a></td>                
                </tr>
                @endforeach
            </table>
            <div class="mt-4">
                {{$users->links()}}{{--ye method pagination k liye use hota hai--}}
            </div>
        </div>
    </div>

    <script>
        //open singal post update modal. ye sara code bootstrap se liya hai lekin changes kari hn
        const updateModal = document.getElementById('updateModal');//apne modal ki id get kari hai
        if (updateModal) {
        updateModal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget;
            if(button){//agar button par click ho           
            //button se attributes ki value lenge
            let id= button.getAttribute('data-id');
            let name= button.getAttribute('data-name');
            let email= button.getAttribute('data-email');
            let age= button.getAttribute('data-age');
            let city= button.getAttribute('data-city');
            let role= button.getAttribute('data-role');

            //in values ko apni input fields me set karenge
            document.querySelector('#inputid').innerHTML = id;
            document.querySelector('#id').value = id;
            document.querySelector('#name').value = name;
            document.querySelector('#email').value = email;
            document.querySelector('#age').value = age;
            document.querySelector('#city').value = city;
            document.querySelector('#role').value = role;

            //form action me iska route set karenge
            updateModal.querySelector('form').action = "{{ route('user.update', ':id') }}".replace(':id',id);//iska matlab neeche define kiya hai verbatim me taakay dollar ka sign dekh kar wo isko real variable consider karlega
            }else{//agar error k baad reopen hoga to id ki value yahan se milegi button se nhi milegi. hamne form fields me value=old diya hai isse purani value auto fill hojaegi
                let id = document.querySelector("#id").value;
                //form action me iska route set karenge
                updateModal.querySelector('form').action = "{{ route('user.update', ':id') }}".replace(':id',id);

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

    @if (session('openModal') == 'UpdateModal'){{--agar update modal me error ayega to ye session create hojayega or hamare local stprage me value set hojaegi--}}
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
        localStorage.removeItem("openmodal");  // remove hone ke liye yaha likhna zaroori hai taakay dubara modal reopen na ho
    }
});
    </script>

@include('pages/footer')