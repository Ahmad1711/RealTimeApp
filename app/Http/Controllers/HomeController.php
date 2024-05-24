<?php

namespace App\Http\Controllers;

use App\Events\NewNotification;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function store_comment(Request $request){

        $comment=Comment::create([
            'content'=>$request->content,
            'post_id'=>$request->post_id,
            'user_id'=>Auth::user()->id,
        ]);

        $data=[
            'user'=>$comment->user->name,
            'comment'=>$comment->content,
            'post'=>$comment->post->title,
        ];

        event(new NewNotification($data));
        return redirect()->route('home')->with(['success'=>'comment added succssfully']);

    }
}
