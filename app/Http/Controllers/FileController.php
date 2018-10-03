<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;

class FileController extends Controller {

    public function index($id) {
        return view('file')->with('id', $id);
    }

    public function uploadImages(Request $request) {
        $imgName = request()->file->getClientOriginalName();
        $newName= md5($imgName).time().$imgName;
        request()->file->move(public_path('images'), $newName);
        $data['image_name']=$newName;
        $data['gallery_id']=$request->input()['id'];        
        $product = Gallery::create($data);
        return response()->json(['uploaded' => '/images/' . $newName]);
    }
    
    public function view(Request $request,$id){
        $data = Gallery::all()->where('gallery_id',$id);
        return view('view')->with('data',$data);
    }

}
