<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileResource extends Controller
{
    public function FileHandler($file , $model , $id){
        $generateName = date('Y-m-d') . '-' . time() . '-' . rand(10000, 999999) . '.' . $file->getClientOriginalExtension();
        $format = $file->getClientOriginalExtension();
        $size = $file->getSize();
        File::create([
            'original_name' => $file->getClientOriginalName(),
            'path' => $generateName,
            'fileable_type' => $model,
            'dir' => $format,
            'size' => $size,
            'fileable_id' => $id
        ]);

        $res = $file->move(public_path(env('Blog_Save_Path')) , $generateName);
        return $res;
    }
}
