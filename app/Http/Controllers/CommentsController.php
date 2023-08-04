<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Comments;
use Illuminate\Http\Request;
use Exception;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /**
         * retrive all post
         */
        $Comments = Comments::all();
        return response()->json(['data' => $Comments]);
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
                'content' => 'required',
                'post_id' => 'required'
            ]);

            //getting the primary key for foreign key relation
            $validatedData['post_id'] = Posts::where('post_id',$request->post_id)->first()->id;

            $comment = Comments::create($validatedData);
            return response()->json(['data' => $comment], 201);

        }catch (Exception $e) {
            return response()->json(['error' => [$e->getMessage()]], $e->status);
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

        $comment = Comments::findOrFail($id);
        return response()->json(['data' => $comment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /**
         * Update comments
         * using id
         */

        try {

            $validatedData = $request->validate([
                'content' => 'required',
            ]);

            $comment = Comments::findOrFail($id);

            $comment->update($validatedData);
            return response()->json(['data' => $comment]);

        }catch (Exception $e) {
            return response()->json(['error' => [$e->getMessage()]], $e->status);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       /**
        * delete any 
        * comment
        */
       $comment = Comments::findOrFail($id);
       $comment->delete();
       return response()->json(['message' => 'comment deleted successfully']);
    }
}
