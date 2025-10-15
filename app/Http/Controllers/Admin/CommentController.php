<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all();
        return view('admin.comments.index' , compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        if($comment->delete()){
            return response()->json(['success' => 'این کامنت با موفقیت حذف شد']);
        }else{
            return response()->json(['error' => 'عملیات با خطا مواجه شد . لطفا دوباره تلاش کنید']);
        }
    }

    public function toggle(Comment $comment)
    {
        $comment->status = $comment->status === 'approved' ? 'seen' : 'approved';
        $comment->save();

        return response()->json(['status' => $comment->status]);
    }
}
