<?php

namespace App\Providers;

use App\Academia;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Division;
use App\Policies\DivisionPolicy;
use App\Departamento;
use App\Policies\AcademiaPolicy;
use App\Policies\DepartamentoPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        #'App\Model' => 'App\Policies\ModelPolicy',
        Division::class => DivisionPolicy::class,
        Academico::class => AcademicoPolicy::class,
        Departamento::class => DepartamentoPolicy::class,
        User::class => UserPolicy::class,
        Academiaa::class => AcademiaPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
