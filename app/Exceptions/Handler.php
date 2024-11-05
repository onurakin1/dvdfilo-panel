<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Inertia\Inertia;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
  public function register()
   {
        $this->renderable(function(Exception $e, $request) {
            return $this->handleException($request, $e);
        });
    }

    // public function render($request, Throwable $e)
    // {
    //     // $response = parent::render($request, $e);

    //     // if (!app()->environment(['local', 'testing']) && in_array($response->status(), [500, 503, 404, 403, 402])) {
    //     //     return Inertia::render('Admin/Exception/Error', ['status' => $response->status()])
    //     //         ->toResponse($request)
    //     //         ->setStatusCode($response->status());
    //     // } else if ($response->status() === 419) {
    //     //     return back()->with([
    //     //         'message' => $e->getMessage(),
    //     //     ]);
    //     // }

    //     // return $response;
        
        

    // }
}
