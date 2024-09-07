<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;

class SettingController extends Controller
{
    public function index(){
        $slide = Slide::all();
        return view('admin.components.setting',compact('slide'));
    }
    public function edit(string $id){
        $slide = Slide::find($id);
        return view('admin.components.settingSlide',compact('slide'));
    }
}
