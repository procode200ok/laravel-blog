<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use App\Models\Posts;
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
        $tags = Tags::all();
        return response()->json(['data' => $tags]);
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
                'name'    => 'required',
                'post_id' => 'required'
            ]);
            $validatedData['post_id'] = Posts::where('post_id',$request->post_id)->first()->id;

            if(empty(Tags::where('name',$validatedData['name'])->first()))
            {
                $tagData = [
                    'name' => $request->name
                ];
                
                $tag =  Tags::create($tagData);

                $postTagData = [
                    'post_id' => Posts::where('post_id',$request->post_id)->first()->id,
                    'tag_id'  => $tag->id
                ];
               
                $postTag = PostTag::create($postTagData);

                return response()->json(['data' => [$tag,$postTag]], 201);
            }else{
                $tagId =  Tags::where('name',$validatedData['name'])->first()->id;
                
                $postTagData = [
                    'post_id' => Posts::where('post_id',$request->post_id)->first()->id,
                    'tag_id'  => $tagId
                ];

                $postTag = PostTag::create($postTagData);
                
                return response()->json(['data' => $postTag], 201);
            }

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
        $tag = Tags::findOrFail($id);
        return response()->json(['data' => $tag]);
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

            $tag = Tags::findOrFail($id);
            $tag->update($validatedData);
            return response()->json(['data' => $tag]);

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
       $tag = Tags::findOrFail($id);
       $tag->delete();
       return response()->json(['message' => 'Post Tag deleted successfully']);
    }
}
