<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\File;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->with('file')->get();
        return view('pages.blog.index' , compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'title' => 'required',
            'text' => 'required',
            'file' => 'required'
        ]);

        $blog = Blog::create([
            'title' => $request->title,
            'text' => $request->text
        ]);

        $this->FileHandler($request->file('file'), "App\Models\Blog" , $blog->id);
        return route('admin.blogs.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        // return view('pages.blog.edit' , compact($blog));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('pages.blog.edit' , compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required',
            'text' => 'required'
        ]);

        $blog->update([
            'title' => $request->title,
            'text' => $request->text
        ]);

        if($request->has('file')){
            $blog->file()->delete();
            $this->FileHandler($request->file , "App\Models\Blog" , $blog->id);
        }

        return redirect()->route('admin.blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

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
