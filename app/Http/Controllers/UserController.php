<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function logincheck(Request $request){
        $credentials = $request->validate([//user ne jo detail dali hai usko validate krna hai
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt($credentials)){//attempt ek method hai iske andar ham ek data pas karenge jo hamara $credentials hai isme hamne apne form ka data store kiya tha upper. email or password field. to ye indono fields ko kisi database k table me check karega agar isko ye field ka data milgaya to hame ek route par redirect kardega. or hamara session bhi khud se create kardega. storage/framework/sessions k andar hamara session store hojata hai
            $currentuserid = Auth::user()->id;//hamare login user ka naam
            $currentuser = Auth::user()->name;//hamare login user ka naam
            $currentrole = Auth::user()->role;//hamare login user ka role
            // if(Auth::user()->role === "admin"){
            //     return redirect()->route('dashboard')->with('current_user',$currentuser)->with('current_role',$currentrole);//view file me send
            // }else{
                return redirect()->route('homepage')->with('current_user',$currentuser)->with('current_role', $currentrole)->with('current_user_id', $currentuserid);
           // }
            //ye Auth class sirf ek hi table check karegi jis ka naam hai users. to hame lazmi users naam se table banana hai. or us table k andar username/email or password ki fields bhi laazmi deni hai.
            //lekin agar ham users table use na krna chahen or user ki details kisi aur table me store krna chahen to uske liye config/auth.php me table ki default value "users" ko change kar skte hn.

            //ab jese hamne attempt method ka use kiya hai wese hi hamare pas aur bhi methods hn
            //2-Auth::user()//ye method authentic user ki sari details return karta hai  
            //3-Auth::id()//ye method authentic user ki id return karta hai  
            //ye dono method sirf tab validate hongay jab hamara user authenticate hojayega
            //4-Auth::check()//is method se ham check karte hn k user login hai
            //5-Auth::guest()//is method se ham check karte hn k agar user login nhi hai. ye check() ka opposite method hai
            //6-Auth::logout()//is method se ham user ko logout karwate haim.

        }else{
            return redirect()->route('login')->with('message','Invalid credentials');
        }

    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('message','you logged out successfully');
    }

    public function block(){

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$users = User::all();
        $users = User::with('posts')->simplePaginate(2);//ye pagination method hai matlab 1 page par sirf 2 records show hongay
        $userid = Auth::user()->id;
        $user = User::find($userid);
        return view('allusers',compact('users','user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        


        $user = User::create([
            'name' => $request->username,
            'email' => $request->useremail,
            'age' => $request->userage,
            'city' => $request->usercity,
            'role' => $request->userrole,
            'password' => $request->userpassword
        ]);

        if(Auth::check()){
            return redirect()->route('user.index')->with('message','User added successfully');
        }else{
            return redirect()->route('login')->with('message2','User registered successfully');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $single_user = User::find($id);
        $single_user_posts = Post::with('users')->where('userid', '=', $id )->get();

        return view('singlepostsuser',compact('single_user_posts'));


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

        $validator = Validator::make($request->all(),[
            'username' => 'required',
            'useremail' => 'email|unique|required',
            'userage' => 'required|numeric|min:18|max:28',
            'usercity' => 'required',
            'userrole' => 'required',
        ]);

        if($validator->fails()){
            return redirect()
            ->back()//back() matlab User ko usi page par redirect karta hai jahan se request aayi thi (previous page).
            ->withErrors($validator)
            ->withInput()//withInput() matlab User ka pehle se diya hua data (form values) dobara wapas input fields me populate karne ke liye store karta hai.
            ->with('openModal','UpdateModal');//  or with() matlab agar validation fail hogyi to ye session create hojayega or phr ham balde me is session ko if condition me de kar apna modal open hi rakhenge. matlab isse hamara  modal band nhi hoga.
            //->with('updateid',$id);//ham ek id ka session bhi banadenge takay agar model reopen hoga to usko id ki valuje milsake k kis user k data ko update krna hai
        }
        
         User::find($id)->update([
            'name' => $request->username,
            'email' => $request->useremail,
            'age' => $request->userage,
            'city' => $request->usercity,
            'role' => $request->userrole
        ]);

         return redirect()->back()->with('message', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();        
        return redirect()->route('user.index')->with('message','User deleted successfully');
    }

    //custom method banaye hn qk usercontroller par validrole middleware laga hua hai

    public function userstore(UserRequest $request){
         $user = User::create([
            'name' => $request->username,
            'email' => $request->useremail,
            'age' => $request->userage,
            'city' => $request->usercity,
            'role' => $request->userrole,
            'password' => $request->userpassword
        ]);

        if($user){
              return redirect()->route('login')->with('message2','User registered successfully');
        }
          
        
    }


    // public function userupdateshow(string $id){
        
    // session(['userupdatemodal' => true, 'selectedUser' => $id]);//Laravel ka session() helper ek session variable set kar raha hai:

    
    // $user = User::find($id);

    // $posts = Post::with('users')->simplepaginate(4);//pagination k liye use hoga
    // return view('usersposts', compact('user','posts'));

    // }

    public function userupdate(Request $request, string $id){
        $rules = [
            'username' => 'required',
            'useremail' => 'email|required',
            'userage' => 'required|numeric|min:18|max:28',
            'usercity' => 'required',
            'userrole' => 'required',
            'password' => 'required',
            'userpassword' => 'required',
        ];

        if($request->userrole === "admin"){
            $rules['password'] = 'required|in:secret123';
        }else{
            $rules['password'] = 'nullable';
        }

        $validator = validator::make($request->all(), $rules);

        if($validator->fails()){
           return redirect()->back()->withErrors($validator)->withInput()->with('userupdatemodal','userupdatemodal');
        }

        $user = User::find($id)->update([
            'name' => $request->username,
            'email' => $request->useremail,
            'age' => $request->userage,
            'city' => $request->usercity,
            'role' => $request->userrole,
            'password' => $request->userpassword,
        ]);

        if($user){
            session()->forget('userupdatemodal'); // session clear kar diya
            return redirect()->back()->with('message','your profile updated successfully');
        }
    }

    public function userdestroy($id){
        $userdelete = User::find($id);
        $userdelete->delete();

        return redirect()->route('guestuser')->with('message','You successfully deactivate your account');
    }
}
