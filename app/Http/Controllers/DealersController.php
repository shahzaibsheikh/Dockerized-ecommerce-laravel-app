<?php

namespace App\Http\Controllers;

use App\Models\Dealers;
use App\Http\Requests\StoreDealersRequest;
use App\Http\Requests\UpdateDealersRequest;

class DealersController extends Controller
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
     * @param  \App\Http\Requests\StoreDealersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDealersRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dealers  $dealers
     * @return \Illuminate\Http\Response
     */
    public function show(Dealers $dealers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dealers  $dealers
     * @return \Illuminate\Http\Response
     */
    public function edit(Dealers $dealers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDealersRequest  $request
     * @param  \App\Models\Dealers  $dealers
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDealersRequest $request, Dealers $dealers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dealers  $dealers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dealers $dealers)
    {
        //
    }
}
