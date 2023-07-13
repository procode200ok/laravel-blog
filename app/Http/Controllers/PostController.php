<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /**
         * retrive all post
         */
        $posts = Posts::all();
        return response()->json(['data' => $posts]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /**
         * Validate request
         * and add title
         */
        try {

            $validatedData = $request->validate([
                'title' => 'required',
                'content' => 'required',
            ]);

            $post = Posts::create($validatedData);
            return response()->json(['data' => $post], 201);

        }catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /**
         *  Find the post by ID
         */ 
        $post = Posts::findOrFail($id);
        return response()->json(['data' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /**
         * Update post
         * using id
         */
        try {

            $validatedData = $request->validate([
                'title' => 'required',
                'content' => 'required',
            ]);

            $post = Posts::where('post_id',$id)->first();

            $post->update($validatedData);
            return response()->json(['data' => $post]);

        }catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       /**
        * delete any 
        * post
        */
       $post = Posts::where('post_id',$id)->first();
       $post->delete();
       return response()->json(['message' => 'Post deleted successfully']);
    }
}
