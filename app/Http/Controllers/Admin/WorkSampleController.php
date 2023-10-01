<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FileResource;
use App\Models\File;
use App\Models\workSample;
use Illuminate\Http\Request;

class WorkSampleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $works = workSample::latest()->get();
        return view('pages.workSamples.index' , compact('works'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.workSamples.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fileResource = new FileResource();
        $request->validate([
            'title' => 'required',
            'text' => 'required',
            'file' => 'required'
        ]);

        $work = workSample::create([
            'title' => $request->title,
            'text' => $request->text
        ]);

        foreach ($request->file('file') as $key => $value) {
            $fileResource->FileHandler($value , "App\Models\workSample" , $work->id);
        }
        return redirect()->route('admin.works.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(workSample $work)
    {
        return view('pages.workSamples.edit' , compact('work'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, workSample $work)
    {
        $fileResource = new FileResource();
        $work->update([
            'title' => $request->title,
            'text' => $request->text
        ]);

        if($request->has('file')){
            foreach ($request->file('file') as $key => $value) {
                $fileResource->FileHandler($value , "App\Models\workSample" , $work->id);
            }
        }

        return redirect()->route('admin.works.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function destroyImage($id){
        $file = File::find($id);
        $file->delete();
        return redirect()->back();
    }
}
