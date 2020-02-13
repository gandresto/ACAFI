<?php

namespace App\Http\Controllers\Api;

use App\Academia;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AcademiaResource;

class UserAcademiasQueHaPresididoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $actual = $request->input('actual');
        if($actual && $actual==1)
            return AcademiaResource::collection($user->academiasQuePreside->sortBy('nombre'));
        return AcademiaResource::collection($user->academiasQueHaPresidido->sortBy('nombre'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @param  \App\Academia  $academia
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Academia $academia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @param  \App\Academia  $academia
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Academia $academia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @param  \App\Academia  $academia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Academia $academia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @param  \App\Academia  $academia
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Academia $academia)
    {
        //
    }
}
