<?php

namespace App\Services;

use App\Contracts\ApiClientInterface;
use Illuminate\Support\Facades\Http;

class FakeStoreApiService implements ApiClientInterface
{
    public function get(): array
    {
        $response = Http::get(config('config.fake_store_api'));

        if ($response->failed()) {
            throw new \Exception("API request failed: " . $response->getMessage(), $response->status());
        }

        return json_decode($response->body(), true);
    }
}
