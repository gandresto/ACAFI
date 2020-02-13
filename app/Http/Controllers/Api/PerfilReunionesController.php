<?php

namespace App\Http\Controllers\Api;

use App\Reunion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReunionResource;
use App\Http\Resources\VueCalendarEventResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PerfilReunionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $reuniones = Cache::remember("reuniones-user-{$user->id}", 60, function () use ($user) {
            return $user->reuniones;
        });
        if($request->input('vuecal') == 1){
            return VueCalendarEventResource::collection($reuniones);
        } else{
            return ReunionResource::collection($reuniones);
        }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reunion  $reunion
     * @return \Illuminate\Http\Response
     */
    public function show(Reunion $reunion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reunion  $reunion
     * @return \Illuminate\Http\Response
     */
    public function edit(Reunion $reunion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reunion  $reunion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reunion $reunion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reunion  $reunion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reunion $reunion)
    {
        //
    }
}
