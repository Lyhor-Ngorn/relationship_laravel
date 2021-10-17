<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  Comment::with(['user', 'post'])->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = new Comment();

        $comment->user_id = $request->user_id;
        $comment->post_id = $request->post_id;
        $comment->comment = $request->comment;

        $comment->save();
        
        return response()->json(['Message' => 'Created', 'data', $comment], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Comment::with(['user', 'post'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        $comment->user_id = $request->user_id;
        $comment->post_id = $request->post_id;
        $comment->comment = $request->comment;

        $comment->save();
        
        return response()->json(['Message' => 'Updated', 'data', $comment], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDelete = Comment::destroy($id);

        if($isDelete == 1) {
            return response()->json('Deleted');
        } else {
            return response()->json('Cannot find ID');
        }
    }
}
