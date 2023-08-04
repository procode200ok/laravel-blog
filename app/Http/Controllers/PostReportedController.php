<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use App\Models\ReportedPosts;
use Exception;

class PostReportedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /**
         * get all reported 
         * post list
         */
        $reportedPosts = ReportedPosts::all();
        return response()->json(['data' => $reportedPosts]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /**
         * create new report
         * against a post
         */

        try{

            $validatedData = $request->validate([
                'reson'   => 'required',
                'post_id' => 'required'
            ]);
            $validatedData['post_id'] = Posts::where('post_id',$request->post_id)->first()->id;

            $report =  ReportedPosts::create($validatedData);
            return response()->json(['data' => $report], 201);
        }catch (Exception $e){
           return response()->json(['error' => [$e->getMessage()]], $e->status);
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
        $report = ReportedPosts::findOrFail($id);
        return response()->json(['data' => $report]);
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
                'reson' => 'required',
            ]);

            $report = ReportedPosts::findOrFail($id);
            $report->update($validatedData);
            return response()->json(['data' => $report]);

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
         * post tag
         */
       $report = ReportedPosts::findOrFail($id);
       $report->delete();
       return response()->json(['message' => 'report deleted successfully']);
    }
}
