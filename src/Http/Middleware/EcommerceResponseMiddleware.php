<?php

namespace Exxtensio\EcommerceCore\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EcommerceResponseMiddleware
{
    /**
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (!$request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'This endpoint requires JSON responses. Please add "Accept: application/json" to your request headers.',
            ], 406);
        }

        if ($response instanceof JsonResponse) {
            $responseData = $response->getData();

            $status = $response->status();
            $isSuccess = in_array($status, [200, 201, 204]);
            $message = match ($status) {
                200 => $this->getCompletedMessage($request),
                201 => 'Resource created successfully',
                204 => 'No content',
                default => 'An error occurred'
            };

            $formattedResponse = [
                'success' => $isSuccess,
                'message' => $message,
                'data' => $isSuccess && $status !== 204 ? $responseData : null,
                'errors' => !$isSuccess ? $responseData->message : null,
            ];

            return response()->json($formattedResponse, $status);
        }

        return $response;
    }

    protected function getCompletedMessage(Request $request): string
    {
        $message = match (class_basename($request->path())) {
            'restore' => 'Resource restored successfully',
            'force-delete' => 'Resource force deleted successfully',
            default => null
        };

        if($message) return $message;

        if(in_array(class_basename($request->path()), ['product-categories', 'product-attributes', 'product-images', 'product-inventory']))
            return 'Request completed successfully';

        return match ($request->method()) {
            'DELETE' => 'Resource deleted successfully',
            'PATCH' => 'Resource updated successfully',
            default => 'Request completed successfully'
        };
    }
}
