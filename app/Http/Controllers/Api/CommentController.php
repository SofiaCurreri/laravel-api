<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|integer|exists:projects,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->fill($request->all());
        $comment->save();

        return response()->json(['success' => 'true']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCommentsByProject($project_id)
    {
        $comments = Comment::where('project_id', $project_id)
            ->orderBy('updated_at', 'DESC')
            ->paginate(6);

        return response()->json($comments);
    }



}