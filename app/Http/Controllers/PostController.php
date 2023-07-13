<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Categories;
use App\Models\PostCategory;
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
        $posts = Posts::all('post_id','title','content');
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
                'category' => 'required'
            ]);

            if(empty(Categories::where('name',$validatedData['category'])->first()))
            {
                $postData = [
                    'title'  => $request->title,
                    'content'=> $request->content
                ];
                $categoryData = [
                    'name' => $request->category
                ];

                $post = Posts::create($postData);
                $category = Categories::create($categoryData);
               
                $postCategoryData = [
                    'post_id'     => $post->post_id,
                    'category_id' => $category->id
                ];

                $postCategory = PostCategory::create($postCategoryData);

                return response()->json(['data' => [$post,$category,$postCategory]], 201);
            }else{

                $postData = [
                    'title'  => $request->title,
                    'content'=> $request->content
                ];

                $post = Posts::create($postData);

                $postCategoryData = [
                    'post_id'     => $post->post_id,
                    'category_id' => Categories::where('name',$validatedData['category'])->first()->id
                ];

                $postCategory = PostCategory::create($postCategoryData);

                return response()->json(['data' => [$post,$postCategory]], 201);
            }

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
