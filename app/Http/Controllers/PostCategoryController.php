<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /**
         * Retrive all
         * post category
         */
        $categories = Categories::all();
        return response()->json(['data' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /**
         * Add new post category
         */
        try{

            $validatedData = $request->validate([
                'name' => 'required'
            ]);

            $categories =  Categories::create($validatedData);
            return response()->json(['data' => $categories], 201);

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
         * show a single category
         */
        $category = Categories::findOrFail($id);
        return response()->json(['data' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /**
         * Update category
         * using id
         */
        try {

            $validatedData = $request->validate([
                'name' => 'required',
            ]);

            $categories = Categories::findOrFail($id);
            $categories->update($validatedData);
            return response()->json(['data' => $categories]);

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
        * category
        */
       $categories = Categories::findOrFail($id);
       $categories->delete();
       return response()->json(['message' => 'category deleted successfully']);
    }
}
