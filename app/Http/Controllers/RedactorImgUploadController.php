<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Image;
use File;
use App\Img;

class RedactorImgUploadController extends Controller
{
	public function imgUpload(Request $request)
    {
        request()->validate([
            // 'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'file' => 'required',
        ]);

        $files = [];
        if ($request->hasFile('file'))
        {
            foreach ($request->file('file') as $key => $file) 
            {
                $image = Image::make($file)->resize(700, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                // $directory = date("Ymd");
                $directory = substr(md5(mt_rand()), 0, 4);

                $directory_full_path = public_path() . '/uploads/img/redactor/' . $directory;
                File::exists($directory_full_path) or File::makeDirectory($directory_full_path);

                $file_name = uniqid() . '.' . $file->getClientOriginalExtension();

                $image->save($directory_full_path . '/' . $file_name);

                $img = new Img();
                $img->imgable_type = 'App\User';
                $img->imgable_id = 1;
                $img->url = '/uploads/img/redactor/' . $directory . '/' . $file_name;
                $img->order = 10;
                $img->tag = 'temp';
                $img->save();

                $files['file'.$key] = [
                    'url' => env('APP_URL') . '/uploads/img/redactor/' . $directory . '/' . $file_name,
                    'id' => $img->id
                ];
            }

            return stripslashes(json_encode($files));
        }
    }   
}
