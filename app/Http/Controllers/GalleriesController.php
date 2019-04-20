<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GalleryRequest;
use Illuminate\Support\Facades\Auth;
use App\Gallery;
use App\Image;
use App\Comment;
class GalleriesController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api')->except(['index','show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $term=$request->query('term');
        if($term){
            return Gallery::search($term)
            ->with([
                'images'=>function($query){
                    $query->latest();
                },
                'user'
            ])->latest()->paginate(10);
        }
        return Gallery::with([
            'images'=>function($query){
                $query->latest();
            },
            'user'
        ])->latest()->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GalleryRequest $request)
    {
        $gallery = new Gallery();
        $gallery->title=$request->title;
        $gallery->description=$request->description;
        $gallery->user_id=Auth::user()->id;
        $gallery->save();
        
        $imagesReq= $request->input('images');
        $images=[];
        foreach($imagesReq as $singleImage){
            $newImage = new Image($singleImage);
            $images[]=$newImage;
        }
        $gallery->images()->saveMany($images);
        return $gallery;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comments=Comment::where('gallery_id','=',$id)->with('user')->get();
        $gallery= Gallery::with([
            'user',
            'images',
            'comments'=>function($query){
                $query->with('user');
            }
        ])->find($id);
        return $gallery;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GalleryRequest $request, Gallery $gallery)
    {
        $gallery->update($request->only([
            'title',
            'description',
          ]));
          $gallery->images()->delete();
          $imagesRequest = $request->input('images');
          $images = [];
          foreach($imagesRequest as $image){
            $newImage = new Image($image);
            $images[] = $newImage;
          }
          $gallery->images()->saveMany($images);
          return $this->show($gallery->id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery=Gallery::find($id);
        $gallery->delete();
        return response()->json([
            'message'=>'Gallery successfully deleted'
        ]);
    }
}
