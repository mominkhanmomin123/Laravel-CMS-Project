<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

// agar foreign key ki values repeat ho rahi hon to ye one to many relationship kehlayega.
// ham is me sara kaam wese hi karnge jese one to one me kiya tha lekin model file k andar hasOne ki jagah hasMany change hoga.
// hamne 2 tables banaye hn users or posts or post table me foreign key hai. wese to ham data apne users table se fetch karte hn lekin posts k case me ham apna zyada tar data posts table se fetch karenge k ye post kis user ki hai. to iske liye inverse relationship ka use hoga. 
// inverse relation me ham posts table k liye wahi kaam krenge jo hamne users table k liye kiya hai. matlab post model file me users naam ka function banayenge or usme ye likhenge 
public function users(){
  return $this->belongsTo(User::class,'userid','id');
    //Pehla parameter 'userid' = posts table ka column (foreign key)
    //Dusra parameter 'id' = users table ka column (primary key)
    //lekin Agar hum posts table me column ka naam user_id rakhte to hame in parameters ki zarurat nhi parti qk laravel automatic is "user_id" column ko foreign key samjh leta hai
}
// matlab hasMany ki jagah belongsTo method ajayega. issay hamara post table ka data pehle show hoga to user table ka data baad me show hoga.


//isi tarah hamne post or comments table ka bhi relationship banaya hai
public function comments(){
  return $this->hasMany(Comment::class,'postid','id');
}

}
