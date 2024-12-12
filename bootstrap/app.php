<?php

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('auth:admin', [
            'auth:sanctum',
            AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e) {
            return response()->json([
                'message' => 'Not Found',
                'errors' => ['Not Found'],
            ], Response::HTTP_NOT_FOUND);
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            return response()->json([
                'message' => $request->method() . ' method is not allowed',
                'errors' => [$request->method() . ' method is not allowed'],
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        });

        $exceptions->render(function (\BadMethodCallException $e) {
            return response()->json([
                'message' => 'Bad method call',
                'errors' => ['Bad method call'],
            ], Response::HTTP_BAD_REQUEST);
        });

        $exceptions->render(function (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => [$e->getMessage()],
            ], $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    })
    ->withCommands([
        __DIR__.'/../app/Domain/Orders/Commands',
    ])
    ->create();
