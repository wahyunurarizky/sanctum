<?php

namespace App\Exceptions;

use App\Enums\STATUS;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (\Exception $e, Request $request) {

            if ($request->is('api/*')) {
                $code = ($e->getCode() || $e->getCode() === 0) ? 500 : $e->getCode();
                $status = $e instanceof AppExeption ? $e->status : STATUS::ERROR;

                if ($e instanceof AuthenticationException) {
                    $code = 401;
                    $status = STATUS::FAIL;
                }

                return response()->json([
                    'status' => $status,
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ], $code);
            }
        });
    }
}
