<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ValidRole;
use App\Http\Middleware\ValidUser;
use Illuminate\Support\Facades\Route;


Route::view('/register','register')->name('register');
Route::view('/login','login')->name('login');

Route::view('/singlepostsuser','singlepostsuser')->name('singlepostsuser')->middleware(ValidUser::class);
Route::view('/usersposts','usersposts')->name('usersposts')->middleware(ValidUser::class);

Route::post('/logincheck',[UserController::class,'logincheck'])->name('logincheck');
Route::post('/logout',[UserController::class,'logout'])->name('logout')->middleware(ValidUser::class);
Route::post('/block',[UserController::class,'block'])->name('block');


Route::view('/dashboard','dashboard')->name('dashboard')->middleware(ValidRole::class);
//Route::view('/allusers','allusers')->name('allusers');
Route::get('/homepage',[PostController::class,'homepage'])->name('homepage')->middleware(ValidUser::class);
Route::get('/',[PostController::class,'guestuser'])->name('guestuser');
Route::get('/myposts',[PostController::class,'myposts'])->name('myposts')->middleware(ValidUser::class);


//resource controller
Route::resource('/post',PostController::class)->middleware(ValidRole::class);
Route::resource('/comment',CommentController::class)->middleware(ValidRole::class);
Route::resource('/user',UserController::class)->middleware(ValidRole::class);


//usercontroller mmanual routing qk resource controller par middleware laga hua hai. jab tak hamara role admin nhi hoga ham resource controler use nhi karsakte. ab user agar apni post ko edit karna chahta hai to uske liye alag route banayenge or resource controller wala code us new route function me ajayega
Route::post('/userstore',[UserController::class,'userstore'])->name('userstore');//qk yahan hame data show karna h issi liye get method
Route::get('/userupdateshow/{id}',[UserController::class,'userupdateshow'])->name('userupdateshow');//qk yahan hame data show karna h issi liye get method
Route::put('/userupdate/{id}',[UserController::class,'userupdate'])->name('userupdate');//yahan hame data update karna hai isi liye put method
Route::delete('/userdestroy/{id}',[UserController::class,'userdestroy'])->name('userdestroy');//yahan hame data delete karna hai isi liye delete method


//postcontroller manual routing qk resource controller par middleware laga hua hai. jab tak hamara role admin nhi hoga ham resource controler use nhi karsakte. ab user agar apni post ko edit karna chahta hai to uske liye alag route banayenge or resource controller wala code us new route function me ajayega

Route::get('/userpostcreate',[PostController::class,'userpostcreate'])->name('userpostcreate');
Route::post('/userspoststore',[PostController::class,'userpoststore'])->name('userpoststore');



//commentcontroller manuak routing
Route::post('/userscommentstore',[CommentController::class,'usercommentstore'])->name('usercommentstore');
Route::get('/userscommentsshow/{id}',[CommentController::class,'userscommentsshow'])->name('userscommentsshow');
Route::put('/usercommentupdate/{id}',[CommentController::class,'usercommentupdate'])->name('usercommentupdate');
Route::delete('/usercommentdestroy/{id}',[CommentController::class,'usercommentdestroy'])->name('usercommentdestroy');