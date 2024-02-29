<?php

namespace App\Http\Controllers;

use App\Models\Salones;
use App\Http\Requests\StoreSalonesRequest;
use App\Http\Requests\UpdateSalonesRequest;

class SalonesController extends Controller
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
     * @param  \App\Http\Requests\StoreSalonesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSalonesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Salones  $salones
     * @return \Illuminate\Http\Response
     */
    public function show(Salones $salones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Salones  $salones
     * @return \Illuminate\Http\Response
     */
    public function edit(Salones $salones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSalonesRequest  $request
     * @param  \App\Models\Salones  $salones
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSalonesRequest $request, Salones $salones)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salones  $salones
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salones $salones)
    {
        //
    }
}
