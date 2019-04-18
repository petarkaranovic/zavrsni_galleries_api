<?php

namespace App\Http\Controllers;
use App\Comment;
use App\Http\Requests\CommentRequest;

use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }
    public function store(CommentRequest $request,$galleryId){
        $newComment = new Comment();
        $newComment->content=$request->content;
        $newComment->user_id=auth()->user()->id;
        $newComment->gallery_id=$galleryId;
        $newComment->save();

        $comment = Comment::with('user')->find($newComment->id);
        return $comment;
    }
    public function destroy($id){
        $comment = Comment::find($id);
        $comment->delete();
        return response()->json([
            'message'=>'Comment successfully deleted'
        ]);
    }
}
