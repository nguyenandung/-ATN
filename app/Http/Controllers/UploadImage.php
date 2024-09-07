<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadImage extends Controller
{
    public function upload(Request $request){

        // $request->validate([
        //      'upload' => 'required|image|mimes:jpg,png|max:2048', // Hạn chế loại tệp là JPG và PNG, tối đa 2MB
        // ]);
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
    
            $request->file('upload')->move(public_path('assets/uploads/'), $fileName);
    
            $url = asset('assets/uploads/' . $fileName);
            return response()->json(['fileName' => $request,'uploaded'=>1,'url'=>$url]);
        }
    }
}
