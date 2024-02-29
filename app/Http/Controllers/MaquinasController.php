<?php

namespace App\Http\Controllers;

use App\Models\Maquinas;
use App\Http\Requests\StoreMaquinasRequest;
use App\Http\Requests\UpdateMaquinasRequest;

class MaquinasController extends Controller
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
     * @param  \App\Http\Requests\StoreMaquinasRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMaquinasRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Maquinas  $maquinas
     * @return \Illuminate\Http\Response
     */
    public function show(Maquinas $maquinas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Maquinas  $maquinas
     * @return \Illuminate\Http\Response
     */
    public function edit(Maquinas $maquinas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMaquinasRequest  $request
     * @param  \App\Models\Maquinas  $maquinas
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMaquinasRequest $request, Maquinas $maquinas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Maquinas  $maquinas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Maquinas $maquinas)
    {
        //
    }
}
