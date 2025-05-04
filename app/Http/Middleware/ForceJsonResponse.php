<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

        try {
            $response = $next($request);

            if ($this->isDebugResponse($response)) {
                return $response;
            }

            if (! $this->isJsonResponse($response)) {
                return response()->json(
                    $response->getContent(),
                    $response->getStatusCode(),
                    $response->headers->all()
                );
            }

            return $response;

        } catch (Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTrace() : null,
            ], $this->getStatusCodeFromException($e));
        }
    }

    protected function isDebugResponse(Response $response): bool
    {
        return str_contains($response->getContent(), '<style class="sf-dump-styles">') ||
               $response->getContent() instanceof \Symfony\Component\VarDumper\Dumper\HtmlDumper;
    }

    protected function isJsonResponse(Response $response): bool
    {
        return str_contains($response->headers->get('Content-Type'), 'application/json');
    }

    protected function getStatusCodeFromException(Throwable $e): int
    {
        return method_exists($e, 'getStatusCode')
            ? $e->getStatusCodeFromException()
            : Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
