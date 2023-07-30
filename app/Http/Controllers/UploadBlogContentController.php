<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Blobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class UploadBlogContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $disk = Storage::disk('s3');

        return $disk;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /**
         * store a file 
         * in s3
         */
        try
        {
            $name = $request->imageFile->getClientOriginalName();
            $extension = $request->imageFile->extension();

            $fileName =  rand().'~'.$name;
         
            /**
             * write to blob schema
             */
            $fileData = [
                'fileName' => $fileName,
                'type'     => 'image',
                'extension'=> $extension,
                'post_id'  => Posts::where('post_id',$request->post_id)->first()->id
            ];

            $blobData = Blobs::create($fileData);
            Storage::disk('s3')->put('lavael-blog/'.$fileName, file_get_contents($request->file('imageFile')));

            $url = Storage::disk('s3')->url('lavael-blog/'.$fileName);
            
            return  response()->json(['data' => $blobData, 'url' => $url], 201);

        }catch(\Exception $e){
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $disk = Storage::disk('s3');

        return $disk;
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
    public function destroy(string $id)
    {
        //
    }

    public function testDisk()
    {
      
        //    Storage::put('test2/helo.txt',"hjdfjfhjfdhj");

        //    return Storage::get('helo.txt');

        $disk = Storage::disk('s3');

        return $disk->get('test4/helo.txt');

        // return 'ok';
     
    }
}
