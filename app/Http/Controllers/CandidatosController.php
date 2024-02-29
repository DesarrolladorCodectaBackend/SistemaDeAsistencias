<?php

namespace App\Http\Controllers;

use App\Models\Candidatos;
use App\Http\Requests\StoreCandidatosRequest;
use App\Http\Requests\UpdateCandidatosRequest;

class CandidatosController extends Controller
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
     * @param  \App\Http\Requests\StoreCandidatosRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCandidatosRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidatos  $candidatos
     * @return \Illuminate\Http\Response
     */
    public function show(Candidatos $candidatos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Candidatos  $candidatos
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidatos $candidatos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCandidatosRequest  $request
     * @param  \App\Models\Candidatos  $candidatos
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCandidatosRequest $request, Candidatos $candidatos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Candidatos  $candidatos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidatos $candidatos)
    {
        //
    }
}
