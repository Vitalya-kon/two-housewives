<?php

namespace App\Http\Controllers;

use App\Models\ServiceCleaning;
use Illuminate\Http\Request;

class ServiceCleaningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ServiceCleaning::orderBy('created_at', 'desc')->get();
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
        $request->validate([
            'service' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $serviceCleaning = new ServiceCleaning;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/services'), $filename);
            $serviceCleaning->url_image = '/images/services/'.$filename;
        }

        $serviceCleaning->service = $request->get('service');
        $serviceCleaning->description = $request->get('description');
        $serviceCleaning->from_price = $request->get('from_price');
        $serviceCleaning->to_price = $request->get('to_price');
        $serviceCleaning->from_last_price = $request->get('from_last_price');
        $serviceCleaning->to_last_price = $request->get('to_last_price');

        $serviceCleaning->save();

        return $serviceCleaning;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceCleaning  $serviceCleaning
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceCleaning $serviceCleaning)
    {
        return $serviceCleaning;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceCleaning  $serviceCleaning
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceCleaning $serviceCleaning)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceCleaning  $serviceCleaning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'service' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $serviceCleaning= ServiceCleaning::find($id);
        $serviceCleaning->service = $request->get('service');
        $serviceCleaning->description = $request->get('description');
        $serviceCleaning->from_price = $request->get('from_price');
        $serviceCleaning->to_price = $request->get('to_price');
        $serviceCleaning->from_last_price = $request->get('from_last_price');
        $serviceCleaning->to_last_price = $request->get('to_last_price');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/services'), $filename);
            $serviceCleaning->url_image = '/images/services/'.$filename;
        }

        $serviceCleaning->save();

        return $serviceCleaning;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceCleaning  $serviceCleaning
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceCleaning $serviceCleaning)
    {
        $serviceCleaning->delete();

        return response()->json(['message' => 'Service deleted successfully']);
    }
}
