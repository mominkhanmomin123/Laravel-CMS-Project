<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $guarded = [];
    public $timestamps = false;

    //hamare pas 2 tables hn users or posts. agar hamne in dono ko foreign se connect kiya hai or hame indono tables ko join karwana hai to hasMany method se join karwaenge
    public function posts(){//ek custom function banaenge
        return $this->hasMany(Post::class, 'userid', 'id');//$this matlab hamara users table ki model file. hasMany matlab one to one relation.isme apne table ko connect kardenge
        //Pehla parameter 'userid' = posts table ka column (foreign key)
        //Dusra parameter 'id' = users table ka column (primary key)
        //lekin Agar hum posts table me column ka naam user_id rakhte to hame in parameters ki zarurat nhi parti qk laravel automatic is "user_id" column ko foreign key samjh leta hai
    }
    public function comments(){//ek custom function banaenge
        return $this->hasMany(Comment::class, 'userid', 'id');//$this matlab hamara users table ki model 
    }
    
    protected function casts(): array
    {
        return [
            'password' => 'hashed'
        ];
    }
}
