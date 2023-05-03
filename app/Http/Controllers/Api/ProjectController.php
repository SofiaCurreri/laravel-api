<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Type;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::where('is_published', true)
            ->with('type', 'technologies')
            ->orderBy('updated_at', 'DESC')
            ->paginate(6);

        foreach($projects as $project) {
            // $project->text = $project->getAbstract(180);
            $project->image = $project->getImageUri();
        }

        return response()->json(compact('projects'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $project = Project::where('slug', $slug)->with('type', 'technologies')->first();
        if(!$project) return response(null, 404);

        $project->image = $project->getImageUri();

        return response()->json($project);
    }


    public function getProjectsByType($type_id)
    {
        $projects = Project::where('type_id', $type_id)
        ->where('is_published', true)
        ->with('type', 'technologies')
        ->orderBy('updated_at', 'DESC')
        ->paginate(6);

        $type = Type::find($type_id);

        foreach($projects as $project) {
            $project->image = $project->getImageUri();
        }
        
        return response()->json(compact('projects', 'type'));
    }
}