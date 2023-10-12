<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkResource;
use App\Models\workSample;
use Illuminate\Http\Request;

class WorkSampleController extends Controller
{
    public function getAll(){
        $works = workSample::latest()->get();
        return response()->json(WorkResource::collection($works));
    }

    public function get(workSample $work){
        return response()->json(new WorkResource($work));
    }
}
