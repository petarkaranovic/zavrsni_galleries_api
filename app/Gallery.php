<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable=[
        'title','description','user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public static function search($term){
        if($term){
            return self::where(function($que) use ($term){
                $que->where('title','like','%'.$term.'%')
                    ->orWhere('description','like','%'.$term.'%')
                    ->orWhereHas('user', function($q) use ($term){
                        $q->where('first_name','like','%'.$term.'%')
                          ->orWhere('last_name','like','%'.$term.'%');
                    });
            });
        }
    }
}
