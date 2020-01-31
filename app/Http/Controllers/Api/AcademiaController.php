<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Academia;
use App\Http\Resources\AcademiaResource;
use App\Http\Resources\AcuerdoPendienteResource;
use Illuminate\Support\Facades\Cache;

class AcademiaController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Cache::remember('academia.'.$id, now()->addSeconds(60), function () use ($id) {
            return new AcademiaResource(Academia::findOrFail($id));
        });
        // return new AcademiaResource(Academia::findOrFail($id));
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

    public function acuerdosPendientes(int $academia_id){
        return AcuerdoPendienteResource::collection(Academia::findOrFail($academia_id)->acuerdosPendientes);
    }
}
