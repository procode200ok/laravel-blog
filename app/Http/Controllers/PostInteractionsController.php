<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Interactions;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostInteractionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /**
         * Add like or dislike
         * aginst a post
         */
        try{

            $request->validate([
                'reaction'    => 'required|boolean',
                'post_id' => 'required'
            ]);

            $interactionData = [
                'type'   => $request->reaction,
                'post_id'=> Posts::where('post_id',$request->post_id)->first()->id
            ];

            $interaction = Interactions::create($interactionData);
            return response()->json(['data' => $interaction], 201);
            
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
         * show a single 
         * reaction
         */
        $interaction = Interactions::findOrFail($id);
        return response()->json(['data' => $interaction]);
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
                'reaction' => 'required|boolean',
            ]);

            $interaction = Interactions::findOrFail($id);
            $interaction->update($validatedData);
            return response()->json(['data' => $interaction]);

        }catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
