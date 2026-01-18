<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CekLevel;
use App\Http\Middleware\CheckActiveGuard;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'auth' => Authenticate::class,
            'ceklevel' => CekLevel::class,
            'active.guard' => CheckActiveGuard::class
        ]);

    })
     ->withSchedule(function (Schedule $schedule) {  // ← INI DIA!
        $schedule->command('members:deactivate-old')
                 ->dailyAt('00:00')
                 ->timezone('Asia/Jakarta');
    })
    
    ->withExceptions(function (Exceptions $exceptions) {
    $exceptions->render(function (QueryException $e, Request $request) {
        if (str_contains($e->getMessage(), 'Out of range value') || 
            str_contains($e->getMessage(), 'Numeric value out of range') ||
            str_contains($e->getMessage(), '1264')) {
            
            return back()
                ->with('error', 'Jumlah terlalu besar! Maksimal Rp 99.999.999.999.999,99')
                ->withInput();
        }
        
        // Biarkan exception lain ditangani secara default
        return null;
    });
    })->create();
