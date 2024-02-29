<?php

namespace App\Http\Controllers;

use App\Models\Colaboradores;
use App\Http\Requests\StoreColaboradoresRequest;
use App\Http\Requests\UpdateColaboradoresRequest;

class ColaboradoresController extends Controller
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
     * @param  \App\Http\Requests\StoreColaboradoresRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreColaboradoresRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Colaboradores  $colaboradores
     * @return \Illuminate\Http\Response
     */
    public function show(Colaboradores $colaboradores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Colaboradores  $colaboradores
     * @return \Illuminate\Http\Response
     */
    public function edit(Colaboradores $colaboradores)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateColaboradoresRequest  $request
     * @param  \App\Models\Colaboradores  $colaboradores
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateColaboradoresRequest $request, Colaboradores $colaboradores)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Colaboradores  $colaboradores
     * @return \Illuminate\Http\Response
     */
    public function destroy(Colaboradores $colaboradores)
    {
        //
    }
}
