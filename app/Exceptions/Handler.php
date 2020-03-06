<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the throwable types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an extension.
     *
     * @param  \Throwable  $extension
     * @return void
     */
    public function report(Throwable $extension)
    {
        parent::report($extension);
    }

    /**
     * Render an extension into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $extension
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $extension)
    {
        // if ($extension instanceof ModelNotFoundException && $request->wantsJson()) {
        //     return response()->json(['message' => 'No se encontró el recurso'], 404);
        // }
        return parent::render($request, $extension);
    }
}
