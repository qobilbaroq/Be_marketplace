<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Banner::all();
        return response([
            "massage" => "banner  list",
            "data" => $data,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'img_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $imagename = time().'.'.$request->img_url->extension();
        $request->img_url->move(public_path('image'), $imagename);

        Banner::create([
            'img_url' => url('image/'.$imagename),
            'img_name' => $imagename,

        ]);

        return response(["massage" => "banner  created successfully"], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Banner::find($id);

        if (is_null($data)) {
            return response([
                "massage" => "banner  not found",
                "data" => [],
            ], 404);
        }
        return response([
            "massage" => "banner list",
            "data" => $data,
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'img_url' => 'required',
        ]);


        $data = Banner::find($id);
        if (is_null($data)) {
            return response([
                "massage" => "banner not found",
                "data" => [],
            ], 404);
        }
        
        
        $imagename = time().'.'.$request->img_url->extension();
        $request->img_url->move(public_path('image'), $imagename);

        $data->img_url = $request->img_url;
        $data->img_name = $imagename;
        $data->save();

        return response([
            "massage" => "banner  updated",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Banner::find($id);

        if (is_null($data)) {
            return response([
                "massage" => "banner  not found",
                "data" => [],
            ], 404);
        }

        $data->delete();

        return response([
            "massage" => " banner deleted",
            "data" => $data,
        ]);
    }
}
