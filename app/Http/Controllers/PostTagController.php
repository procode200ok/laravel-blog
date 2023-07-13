<?php

namespace App\Http\Controllers;

use App\Models\PostTag;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /**
         * Retrive all
         * post tags
         */
        $postTags = PostTag::all();
        return response()->json(['data' => $postTags]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /**
         * Add new post tag
         */
        try{

            $validatedData = $request->validate([
                'name' => 'required'
            ]);

            $postTag =  PostTag::create($validatedData);
            return response()->json(['data' => $postTag], 201);

        }catch (ValidationException $e){
            return response()->json(['error' => $e->errors()], 442);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /**
         * show a single post tag
         */
        $postTag = PostTag::findOrFail($id);
        return response()->json(['data' => $postTag]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /**
         * Update post tag
         * using id
         */
        try {

            $validatedData = $request->validate([
                'name' => 'required',
            ]);

            $postTag = PostTag::findOrFail($id);
            $postTag->update($validatedData);
            return response()->json(['data' => $postTag]);

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
        * post tag
        */
       $postTag = PostTag::findOrFail($id);
       $postTag->delete();
       return response()->json(['message' => 'Post Tag deleted successfully']);
    }
}
