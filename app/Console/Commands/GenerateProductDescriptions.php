<?php

namespace App\Console\Commands;

use App\Helpers\OpenAIHelper;
use App\Models\Product;
use App\Models\ProductCategory;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class GenerateProductDescriptions extends Command
{
    /**
     *
     * @var string
     */
    protected $signature = 'generate:product-descriptions {count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'GPT-4 kullanarak ürün açıklamaları ve kategori etiketleri oluştur';


    protected $openAIHelper;

    public function __construct(OpenAIHelper $openAIHelper)
    {
        parent::__construct();
        $this->openAIHelper = $openAIHelper;
    }

    /**
     * Execute the console command.
     * @throws GuzzleException
     */
    public function handle()
    {
        $count = (int)$this->argument('count');

        $productCategories = ProductCategory::query()->get();

        for ($i = 0; $i < $count; $i++) {
            $category = $productCategories->random();
            $result = $this->openAIHelper->generateProductDescription($category->name);

            Product::query()->create([
                'category_id' => $category->id,
                'description' => $result,
            ]);

            $this->info("Oluşturuldu: Kategori - $category, Açıklama - $result");
        }

        $this->info("Toplam $count adet ürün açıklaması ve kategori oluşturuldu.");
    }
}
