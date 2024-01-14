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
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('success', function ($value) {
            return Response::json([
                "statusCode" => 200,
                "data" => $value,
            ]);
        });
    }
}
