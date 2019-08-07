<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Academico;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/academicos';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'grado_id' => 'required|string|max:8',
            'nombre' => 'required|string|max:200|min:3',
            'apellido_pat' => 'required|string|max:200|min:3',
            'apellido_mat' => 'required|string|max:200|min:3',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        #dd($data);

        $academico = new Academico;
        $academico->nombre = $data['nombre'];
        $academico->apellido_pat = $data['apellido_pat'];
        $academico->apellido_mat = $data['apellido_mat'];
        $academico->grado_id = $data['grado_id'];
        $academico->push();

        //$data->session()->flash('status', 'Académico con nombre \''
        //                                        . $data['nombre']
        //                                       .'\' creado satisfactoriamente.');

        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'academico_id' => $academico->id,
        ]);
    }
}
