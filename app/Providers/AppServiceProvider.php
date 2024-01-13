<?php

namespace App\Providers;

use App\Contracts\ApiClientInterface;
use App\Services\FakeStoreApiService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        App::bind(ApiClientInterface::class, FakeStoreApiService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('success', function ($value) {
            return Response::json([
                "success" => true,
                "data" => $value,
            ]);
        });
    }
}
