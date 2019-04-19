<?php

namespace App\Http\Controllers;
use App\Gallery;
use Illuminate\Http\Request;

class MyGalleriesController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }
    
    public function show(Request $request){
        $term = $request->query('term');
        $userId=Auth::user()->id;

        if($term){
            return Gallery::search($term)
            ->where('user_id','=',$userId)
            ->with([
                'images'=>function($query){
                    $query->latest();
                },
                'user'
            ])->latest()->paginate(10);
        }
        return Gallery::where('user_id','=',$userId)
        ->with(['images','user'])
        ->latest()->paginate(10);
    }
}
