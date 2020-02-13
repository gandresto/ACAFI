<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Academia;
use App\Http\Resources\AcademiaResource;
use App\Http\Resources\AcademiasCollection;
use App\Http\Resources\AcuerdoPendienteResource;
use Illuminate\Support\Facades\Cache;

class AcademiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Academia::class);

        // $con_ap = $request->input('con_ap', 0) == 0 ? 0 : 1;
        // $con_miem = $request->input('con_miem', 0) == 0 ? 0 : 1;
        // $con_pres = $request->input('con_pres', 0) == 0 ? 0 : 1;

        // Atributos para eager loading
        // https://laravel.com/docs/5.8/eloquent-relationships#eager-loading
        // $relaciones = [];
        // if($con_ap) array_push($relaciones, 'temas.acuerdos'); 
        // if($con_miem) array_push($relaciones, 'miembros'); 
        // if($con_pres) array_push($relaciones, 'presidentes'); 
        // if( count($relaciones) > 0 ) 
        //     $academias = Academia::with($relaciones)->get();
        // else 
            $academias = Academia::all();
        return new AcademiasCollection(
            $academias
            // $con_ap,
            // $con_miem,
            // $con_pres
        );
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $academia_id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $academia_id)
    {
        $con_ap = $request->input('con_ap', 0) == 0 ? 0 : 1;
        $con_miem = $request->input('con_miem', 0) == 0 ? 0 : 1;
        $con_pres = $request->input('con_pres', 0) == 0 ? 0 : 1;
        $cacheKey = "academia.{$academia_id}?con_ap={$con_ap}&con_miem={$con_miem}&con_pres={$con_pres}";
        return Cache::remember(
                        $cacheKey, 
                        now()->addSeconds(60), 
                        function () use ($academia_id, $con_ap, $con_pres, $con_miem) {
                            return new AcademiaResource(
                                            Academia::findOrFail($academia_id),
                                            $con_ap, $con_miem, $con_pres
                                        );
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
}
