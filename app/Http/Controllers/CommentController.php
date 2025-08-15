<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            'comment' => 'required'
        ]);

        if($validator->fails()){
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput()
            ->with('commentcodal','commentmodal');
        }

        $userid = Auth::user()->id;
        $username = Auth::user()->name;

        $comment = Comment::create([
            'comment' => $request->comment,
            'comment_by' => $username,
            'userid' => $userid,
            'postid' => $request->id//input field se value ayi hai
        ]);


        if($request->route === "allpost"){
            if($comment){
                return redirect()->route('comment.show',$request->id)->with('message','comment added successfully');
            }else{
                return redirect()->route('comment.show',$request->id)->with('message','comment failed');
            }
        }else{
            if($comment){
                return redirect()->route('post.show',$request->id)->with('message','comment added successfully');
            }else{
                return redirect()->route('post.show',$request->id)->with('message','comment failed');
            }
        }
            
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //$comments = Post::with(['users','comments'])->findOrFail($id);//Ye relationships ke naam hain jo tumne Post model me banaye hain:
        //findorfail(): Post ki id se ek record find karega. Agar post nahi mila to automatic 404 error throw karega.
        //hamne agar relationships nhi banae hote to in tables k records ko aese get krte
        $postpic = Post::findOrFail($id);
        //$user = User::find($post->userid);
        $comments = Comment::where('postid',$postpic->id)->get();//sirf is post k comment show honge

         session(['commentmodal' => true, 'selectedPost' => $id]);//Laravel ka session() helper ek session variable set kar raha hai:

        // openModal = true (flag set kar diya ke modal open karna hai)

        // selectedPost = post ki id (taaki pata chale kaunsa modal open hua tha)

        $posts = Post::with('users')->simplePaginate(4);//hamari view (usersposts.blade.php) ek list show kar rahi hai jisme sab posts hote hain.
        return view('allpost', compact('posts', 'comments', 'postpic'));//ye dono variables is file me send kardiye
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
        $request->validate([
            "edit_comment_field" => 'required'
        ]);
        $comment = Comment::find($id);
        $comment->update([
            "comment" => $request->edit_comment_field
        ]);
        $post_id = $request->post_id;

       
            return redirect()->route('comment.show',$post_id)->with('message','comment updated successfully!');
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $comment = Comment::find($id);
        $post_id = $request->postid;
        $comment->delete();

        if($request->route === "allpost"){
           return redirect()->route('comment.show',$post_id)->with('message','comment deleted successfully!'); 
        }else{
            return redirect()->route('post.show',$post_id)->with('message','comment deleted successfully!');
        }
    }

    public function usercommentstore(Request $request){
         $validator = Validator::make($request->all(),[
            'comment' => 'required'
        ]);

        if($validator->fails()){
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput()
            ->with('commentcodal','commentmodal');
        }

        $userid = Auth::user()->id;
        $username = Auth::user()->name;

        $comment = Comment::create([
            'comment' => $request->comment,
            'comment_by' => $username,
            'userid' => $userid,
            'postid' => $request->id//input field se value ayi hai
        ]);


       
            if($comment){
                return redirect()->route('userscommentsshow',$request->id)->with('message','comment added successfully');
            
        }
            
        
        
    }

    public function userscommentsshow($id){
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

    public function usercommentupdate(Request $request, string $id){
        $request->validate([
            "edit_comment_field" => 'required'
        ]);
        $comment = Comment::find($id);
        $comment->update([
            "comment" => $request->edit_comment_field
        ]);
        $post_id = $request->post_id;

        if($request->route === "allpost"){
            return redirect()->route('comment.show',$post_id)->with('message','comment updated successfully!');
        }else{
            return redirect()->route('post.show',$post_id)->with('message','comment updated successfully!');
        }
    }

    public function usercommentdestroy(Request $request, string $id)
    {
        $comment = Comment::find($id);
        $post_id = $request->postid;
        $comment->delete();

        
            return redirect()->route('userscommentsshow',$post_id)->with('message','comment deleted successfully!');
        
    }
}
