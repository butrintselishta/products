<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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
        $this->logException($request, $e);

        if ($e instanceof UnauthorizedHttpException) {
            return $this->handleUnauthorizedException($e);
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->handleNotFoundException($e);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->handleMethodNotAllowedException($e);
        }

        if ($e instanceof ValidationException) {
            return $this->handleValidationException($e);
        }

        return $this->handleGeneralException($e);
    }

    /**
     * Log the exception by providing neccessary informations to debug
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     * @return void
     */
    private function logException(Request $request, Throwable $e)
    {
        Log::error($e->getMessage(), [
            'exception' => get_class($e),
            'request' => $request->all(),
            'user_id' => auth()->id(),
            'url' => $request->url(),
        ]);
    }

    /**
     * Centralized error json response
     * @param int $statusCode
     * @param string $message
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleErrorResponse(int $statusCode, string $message, array $errors = []): JsonResponse
    {
        return response()->json([
            'statusCode' => $statusCode,
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }

    /**
     *
     * @OA\Schema(
     *     type="object",
     *     schema="UnauthenticatedResponse",
     *     @OA\Property(property="statusCode",description="The status code.",type="number",default=401),
     *     @OA\Property(property="message",description="Unauthenticated error message.",type="string",default=""),
     *     @OA\Property(property="errors",description="The list of the errors.",type="array",@OA\Items(type="string"))
     * )
     *
     * Handle unauthorized error reponse
     * @param \Throwable $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleUnauthorizedException(Throwable $e): JsonResponse
    {
        return $this->handleErrorResponse($e->getStatusCode(), $e->getMessage());
    }

    /**
     *
     * @OA\Schema(
     *     type="object",
     *     schema="NotFoundResponse",
     *     @OA\Property(property="statusCode",description="The status code.",type="number",default=404),
     *     @OA\Property(property="message",description="Not found error message.",type="string",default=""),
     *     @OA\Property(property="errors",description="The list of the errors.",type="array",@OA\Items(type="string"))
     * )
     *
     * Handle not found error reponse
     * @param \Throwable $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleNotFoundException(Throwable $e): JsonResponse
    {
        return $this->handleErrorResponse($e->getStatusCode(), $e->getMessage());
    }


    /**
     *
     * @OA\Schema(
     *     type="object",
     *     schema="MethodNotAllowedResponse",
     *     @OA\Property(property="statusCode",description="The status code.",type="number",default=405),
     *     @OA\Property(property="message",description="Method not allowed error message.",type="string",default=""),
     *     @OA\Property(property="errors",description="The list of the errors.",type="array",@OA\Items(type="string"))
     * )
     *
     * Handle method not allowed error reponse
     * @param \Throwable $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleMethodNotAllowedException(Throwable $e)
    {
        return $this->handleErrorResponse($e->getStatusCode(), $e->getMessage());
    }

    /**
     *
     * @OA\Schema(
     *     type="object",
     *     schema="FailedValidationResponse",
     *     @OA\Property(property="statusCode",description="The status code.",type="number",default=422),
     *     @OA\Property(property="message",description="Failed validation error message.",type="string",default=""),
     *     @OA\Property(property="errors",description="The list of the errors.",type="array",@OA\Items(type="string", example={"title": "title is required"})),
     * )
     *
     * Handle validation error reponse
     * @param \Throwable $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleValidationException(Throwable $e): JsonResponse
    {
        return $this->handleErrorResponse($e->status, "", $e->errors());
    }

    /**
     * @OA\Schema(
     *     type="object",
     *     schema="ServerErrorResponse",
     *     @OA\Property(property="statusCode",description="The status code.",type="number",default=500),
     *     @OA\Property(property="message",description="Unauthenticated error message.",type="string",default="Something went wrong, please contact our support."),
     *     @OA\Property(property="errors",description="The list of the errors.",type="array",@OA\Items(type="string"))
     * )
     *
     * Handle general/server error reponse
     * @param \Throwable $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleGeneralException(Throwable $e): JsonResponse
    {
        $message = $e->getMessage() ?? "Something went wrong, please contact our support.";
        return $this->handleErrorResponse(500, $message);
    }
}
