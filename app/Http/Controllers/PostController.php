<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\fileExists;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session()->forget('commentmodal');
        $comments = Comment::with('posts')->get();
        $posts = Post::with('users')->simplepaginate(4);//pagination k liye use hoga. indono ka relation banaya hua tha model me isi liye is tarah likha hai
        return view('allpost',compact('posts','comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('addposts');
    }
    public function userpostcreate()//custom function banaege qk resource controller par validroe middleware lagaya hai hamara role jab tak admin nhi hoga ham is resource controller k route ko use nhi kar sakte
    {
        return view('addposts');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:3000',
            'description' => 'required',
            'category' => 'required'
        ]);

        $userid = Auth::user()->id;//isme hamare login user ki id ajayegi or isko ham apne create method me "userid" column ki value me save karenge. taakay pata chal sake k kis user ne ye post likhi hai

        $image = $request->file('image');//$request variable me form ki input fields hn is me file method hai or us me hamari input field ka naam hai. to is image variable me hamari file se related sara data ajayega
        $imagename = time().'-'.$image->getClientOriginalName();//pehle current time phr file ka naam taakay agar picture repeat ho to overwrite na hojaye


        $imagepath = $image->storeAs('uploads',$imagename,'public');//storeAs() method se ham apni file folder me upload karenge. storage/app/public/uploads folder me hamari image upload hojayegi.

        // ham is image ko public folder ki bajaye ek symbolic storage/app/public folder me save karwaenge qk hamara storage folder secure hota hai lekin hamara public folder user  liye accessible hota is liye ham storage folder ka use karte hn. is folder ko link krne k liye ek command likhni hoti hai
        // php artisan storage:link
        // Ye command public/storage ko storage/app/public se link karega.
        // Agar hum php artisan storage:link command nahi chalate, to image save to ho jayegi,
        // lekin browser me directly access nahi kar paenge.
        //Ye command public/storage ko storage/app/public se link karega.

        $post = Post::create([
            'title' => $request->title,
            'image' => $imagepath,
            'description' => $request->description,
            'category' => $request->category,
            'userid' => $userid
        ]);

        if($post && Auth::user()->role === 'admin'){
            return redirect()->route('post.index')->with('message','Post created successfully!');
        }else{
            return redirect()->route('homepage')->with('message','Post created successfully!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //$comments = Post::with(['users','comments'])->findOrFail($id);//Ye relationships ke naam hain jo tumne Post model me banaye hain:
        //findorfail(): Post ki id se ek record find karega. Agar post nahi mila to automatic 404 error throw karega.
        //hamne agar relationships nhi banae hote to in tables k records ko aese get krte
        $postpic = Post::findOrFail($id);
        //$user = User::find($post->userid);
        $comments = Comment::where('postid',$postpic->id)->get();

         session(['commentmodal' => true, 'selectedPost' => $id]);//Laravel ka session() helper ek session variable set kar raha hai:

        // openModal = true (flag set kar diya ke modal open karna hai)

        // selectedPost = post ki id (taaki pata chale kaunsa modal open hua tha)

        $posts = Post::with('users')->simplePaginate(4);//hamari view (usersposts.blade.php) ek list show kar rahi hai jisme sab posts hote hain.

        $userid = Auth::user()->id;
        $user = User::find($userid);
        return view('usersposts', compact('posts', 'comments', 'postpic','user'));//ye dono variables is file me send kardiye
         
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'category' => 'required',    
        ];

         if(Auth::user()->role === 'admin'){
            $rules['author'] = 'required';//agar admin role ho to author bhi required hoga
         }
         if($request->hasFile('image')){//agar user image field ki image change kare to uspar validation hogi or agar change nhi karega to validation nhi lagegi
            $rules['image'] = 'mimes:png,jpg,jpeg|max:3000';
         }
   
            $validator = Validator::make($request->all(), $rules);
       

        if($validator->fails()){
            return redirect()
            ->back()//back() matlab User ko usi page par redirect karta hai jahan se request aayi thi (previous page).
            ->withErrors($validator)
            ->withInput()//withInput() matlab User ka pehle se diya hua data (form values) dobara wapas input fields me populate karne ke liye store karta hai.
            ->with('openModal','UpdateModal');//  or with() matlab agar validation fail hogyi to ye session create hojayega or phr ham balde me is session ko if condition me de kar apna modal open hi rakhenge. matlab isse hamara  modal band nhi hoga.
            //->with('updateid',$id);//ham ek id ka session bhi banadenge takay agar model reopen hoga to usko id ki valuje milsake k kis user k data ko update krna hai
        }

        $post = Post::find($id);
        //agar user ne update krte waqt image change kari hai to purani image folder se delete hojayegi or new image add hojayegi
        

        // Purani image ka real path (storage/app/public/uploads/...)
        //$old_imagepath = storage_path('app/public/'.$post->image);//hamari image storage folder me hai isi liye storage_path use hoga
        // if($request->hasFile('image') && file_exists($old_imagepath)){//image hamari input field ka naam hai. matlab ye hasFile() method check krta hai k agar hamari input file change hui h ya nhi. or fileExists() method check karega k hamare folder me ye $old_imagepath wala path h ya nhi. 
           //     unlink($old_imagepath);

        
         if($request->hasFile('image')){//image hamari input field ka naam hai. matlab ye hasFile() method check krta hai k agar hamari input file change hui h ya nhi.
             //ham is k elawa laravel ki inbuilt class ka use karenge jo jo storage_path k liye use hogi
         //Storage::disk('public')->exists($post->image); 
         //Laravel ka Storage facade ek wrapper hai jo file system ke sath kaam karne ke liye use hota hai.Laravel me multiple file systems hoti hain (local, public, s3, etc.), jo config/filesystems.php me define hoti hain.
         //"disk" ka matlab hai kis storage location ko target karna hai.
         //'public' ek predefined disk hai jo storage/app/public folder ko point karti hai.
         //Agar humne php artisan storage:link chalaya hai, to ye public/storage ke sath link ho jata hai.
         //exists($post->image)  Ye method check karta hai ki given path par file maujood hai ya nahi.
            if(Storage::disk('public')->exists($post->image)){
                 Storage::disk('public')->delete($post->image);//Agar file exist hai to ye command file ko permanently delete kar deta hai. Path automatically 'public' disk ke base path se resolve hota hai, to humhe full path (storage_path('app/public/...')) manually likhne ki zarurat nahi.Ye secure hai aur Laravel ke storage system ke through hota hai (permission issues ya symbolic link ke problems avoid karne ke liye).
            }               
               //new image add to folder
              
                $image = $request->file('image');
                $imagename = time().'-'.$image->getClientOriginalName();
               
                $image->storeAs('uploads',$imagename,'public');
                $imagepath = 'uploads/'.$imagename;

            }else{
                $imagepath = $post->image;//agar user image change nhi karega to purani image ka wohi path rahega khaali nhi hoga or us path ko hi ham database me image column me save karenge
            }
               
            $post->update([
                'title' => $request->title,
                'image' => $imagepath,
                'description' => $request->description,
                'category' => $request->category,
            ]);

            $user = User::find($post->userid);//hamne users table ka record bhi fetch karliya takay author field change honay par users table me name column change hojaye ga
            
            if($request->filled('author')){//matlab agar user ne author field ki value change kari hai ya usme kuch insert kiya hai tb hi database me store hogi wrna agar user role user hoga or author ki value change nhi hogi to database me change nhi hogas
                $user->update([
                    'name' => $request->author
                 ]);
            }
            

            if(Auth::user()->role === 'admin'){
                if($request->input('url') === 'myposts'){//agar kisi input field k name = "url" value="myposts" hogi to ye is route par redirect hoga
                    return redirect()->route('myposts')->with('message','Post updated successfully');
                }else{
                    return redirect()->route('post.index')->with('message','Post updated successfully');
                }
            }else{
                 return redirect()->route('myposts')->with('message','Post updated successfully');
            }
         

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function homepage()
    {
        session()->forget('commentmodal'); // session clear kar diya
        session()->forget('userupdatemodal'); // session clear kar diya
        $id = Auth::user()->id;
        $user = User::find($id);
        $posts = Post::with('users')->simplepaginate(4);//pagination k liye use hoga
        
        return view('usersposts',compact('posts','user'));
        

    }

    public function guestuser()
    {
        $posts = Post::with('users')->simplepaginate(4);//pagination k liye use hoga
        return view('guestposts',compact('posts'));
    }
    public function myposts()
    {
        $username = Auth::user()->id;
        $posts = Post::with('users')->where('userid',$username)->simplepaginate(4);//sirf us user k post show honge jo login hoga
        return view('myposts',compact('posts'));
    }
    public function mycomments()
    {
        $username = Auth::user()->id;
        $posts = Post::with('users')->where('userid',$username)->simplepaginate(4);//sirf us user k post show honge jo login hoga
        return view('myposts',compact('posts'));
    }
    
    public function userpoststore(Request $request){
        $request->validate([
            'title' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:3000',
            'description' => 'required',
            'category' => 'required'
        ]);

        $userid = Auth::user()->id;//isme hamare login user ki id ajayegi or isko ham apne create method me "userid" column ki value me save karenge. taakay pata chal sake k kis user ne ye post likhi hai

        $image = $request->file('image');//$request variable me form ki input fields hn is me file method hai or us me hamari input field ka naam hai. to is image variable me hamari file se related sara data ajayega
        $imagename = time().'-'.$image->getClientOriginalName();//pehle current time phr file ka naam taakay agar picture repeat ho to overwrite na hojaye


        $imagepath = $image->storeAs('uploads',$imagename,'public');//storeAs() method se ham apni file folder me upload karenge. storage/app/public/uploads folder me hamari image upload hojayegi.

        // ham is image ko public folder ki bajaye ek symbolic storage/app/public folder me save karwaenge qk hamara storage folder secure hota hai lekin hamara public folder user  liye accessible hota is liye ham storage folder ka use karte hn. is folder ko link krne k liye ek command likhni hoti hai
        // php artisan storage:link
        // Ye command public/storage ko storage/app/public se link karega.
        // Agar hum php artisan storage:link command nahi chalate, to image save to ho jayegi,
        // lekin browser me directly access nahi kar paenge.
        //Ye command public/storage ko storage/app/public se link karega.

        $post = Post::create([
            'title' => $request->title,
            'image' => $imagepath,
            'description' => $request->description,
            'category' => $request->category,
            'userid' => $userid
        ]);

        if($post){
            return redirect()->route('homepage')->with('message','Post created successfully!');
        }
    }
}

