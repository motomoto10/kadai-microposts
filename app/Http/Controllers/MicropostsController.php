<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class MicropostsController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            // ユーザとフォロー中ユーザの投稿の一覧を作成日時の降順で取得
            $microposts = $user->feed_microposts()->orderBy('created_at','desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'microposts' => $microposts,
            ];
        }
        
        return view('welcome',$data);
    }
    
    public function store(Request $request)
    {
        $request->validate([
           'content' => 'required|max:255', 
        ]);
        
        $request->user()->microposts()->create([
            'content' => $request->content,    
        ]);
        
        return back();
    }
    
    public function destroy($id)
    {
        $micropost = \App\Micropost::findOrFail($id);
        
        if (\Auth::id() === $micropost->user_id){
            $micropost->delete();
        }
        
        return back();
    }
    
    public function favorite_post($user_id)
    {
        $user = User::findOrFail($user_id);
        
        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();
        
        // ユーザのお気に入りしたユーザーを取得
        $favorits = $user->favorite_users()->paginate(10);
        
        // フォロー一覧ビューでそれらを表示
        return view('users.favorites',[
            'user' => $user,
            'microposts' => $favorits,
        ]);
   }
}
