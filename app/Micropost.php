<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable = ['content'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function favorite_microposts()
    {
        // このユーザがお気に入り中のユーザのidを取得して配列にする
        $micropostIds = $this->favorite()->pluck('microposts.id')->toArray();
        // それらのユーザが所有する投稿に絞り込む
        return Micropost::whereIn('user_id', $micropostIds);
    }
}
