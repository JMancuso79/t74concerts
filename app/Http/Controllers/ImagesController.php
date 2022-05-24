<?php

namespace App\Http\Controllers;

use Image;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
             'file' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:7200'],
        ]);

        // If Validation Fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'fail-validation',
                'errors' => $validator->errors()->all()
            ]);
        } 
        // Validation passes
        else {

            if($request->file()) {
                $fileName = uniqid().'_'.$request->file->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('/images', $fileName, 'public');

                return response()->json([
                    'message' => 'success',
                    'filepath' => $filePath,
                ]); 
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
