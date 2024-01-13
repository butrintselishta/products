<?php

namespace App\Console\Commands;

use App\Contracts\ApiClientInterface;
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

    /**
     * @return void
     */
    public function __construct(
        private ProductService $productService,
        private ApiClientInterface $adapter
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info("Proccess started!");
            $products = $this->adapter->get();

            $progressBar = $this->output->createProgressBar(count($products));
            $progressBar->start();

            DB::transaction(function () use($products, $progressBar) {
                foreach ($products as $productPayload) {
                    $this->productService->importProducts($productPayload);
                    $progressBar->advance();
                }
            });

            $progressBar->finish();
            $this->newLine();
            $this->info("Proccess finished successfully!");
        } catch(Exception $e) {
            throw $e;
        }
    }
}
