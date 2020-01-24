<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Reunion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReunionResource;
use App\Http\Resources\VueCalendarEventResource;

class UserReunionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, int $user_id)
    {
        $user = User::findOrFail($user_id);
        $this->authorize('view', $user);
        if($request->input('vuecal') == 1){
            return VueCalendarEventResource::collection($user->reuniones);
        } else{
            return ReunionResource::collection($user->reuniones);
        }
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
