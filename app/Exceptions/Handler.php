<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
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
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Throwable
     */
    public function render($request, Throwable $e): JsonResponse
    {
        if ($e instanceof UnauthorizedHttpException) {
            return $this->handleUnauthorizedException($e);
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->handleNotFoundException($e);
        }

        if ($e instanceof ValidationException) {
            return $this->handleValidationException($e);
        }
        dd($e);
        return $this->handleGeneralException($e);
    }

    /**
     * Handle unauthorized error reponse
     * @param \Throwable $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleUnauthorizedException(Throwable $e): JsonResponse
    {
        return response()->json([
            'statusCode' => $e->getStatusCode(),
            'message' => $e->getMessage(),
        ], $e->getStatusCode());
    }

    /**
     * Handle not found error reponse
     * @param \Throwable $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleNotFoundException(Throwable $e): JsonResponse
    {
        return response()->json([
            'statusCode' => $e->status,
            'errors' => $e->errors(),
        ], $e->status);
    }

    /**
     * Handle validation error reponse
     * @param \Throwable $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleValidationException(Throwable $e): JsonResponse
    {
        return response()->json([
            'statusCode' => $e->getStatusCode(),
            'message' => $e->getMessage(),
        ], $e->getStatusCode());
    }

    /**
     * Handle general/server error reponse
     * @param \Throwable $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleGeneralException(): JsonResponse
    {
        return response()->json([
            'statusCode' => 500,
            'message' => "Something went wrong, please contact our support.",
        ], 500);
    }
}
