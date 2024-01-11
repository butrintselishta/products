<?php

namespace App\Console\Commands;

use App\Services\ProductService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $getProductsApi;
    protected $productService;

    /**
     * @return void
     */
    public function __construct(ProductService $productService)
    {
        parent::__construct();

        $this->getProductsApi = 'https://fakestoreapi.com/products';

        $this->productService = $productService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info("Proccess started!");
            $products = $this->getProducts();
            $progressBar = $this->output->createProgressBar(count($products));
            $progressBar->start();

            DB::beginTransaction();
            try {
                foreach ($products as $productPayload) {
                    $this->productService->importProducts($productPayload);
                    $progressBar->advance();
                }
                $progressBar->finish();
                $this->newLine();
                $this->info("Proccess finished successfully!");
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch(Exception $e) {
            throw $e;
        }
    }

    /**
     * Summary of getProducts
     * @throws \Exception
     * @return mixed
     */
    private function getProducts()
    {
        $response = Http::get($this->getProductsApi);

        if ($response->failed()) {
            throw new \Exception("API request failed with status code: " . $response->status(), $response->status());
        }

        return json_decode($response->body(), true);
    }
}
