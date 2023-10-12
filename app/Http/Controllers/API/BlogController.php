<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function getAll(){
        $blogs = Blog::latest()->get();
        return response()->json(BlogResource::collection($blogs));
    }

    public function getBlog(Blog $blog){
        return response()->json(new BlogResource($blog));
    }
}
