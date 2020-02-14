<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Academia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class AcademiaMiembrosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Academia  $academia
     * @return \Illuminate\Http\Response
     */
    public function index(Academia $academia)
    {
        return UserResource::collection($academia->miembros);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Academia  $academia
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Academia $academia)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Academia  $academia
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Academia $academia, User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Academia  $academia
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Academia $academia, User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Academia  $academia
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Academia $academia, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Academia  $academia
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Academia $academia, User $user)
    {
        //
    }
}