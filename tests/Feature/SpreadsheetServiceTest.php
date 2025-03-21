<?php

namespace Tests\Feature;

use App\Jobs\ProcessProductImage;
use App\Models\Product;
use App\Services\SpreadsheetService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class SpreadsheetServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->importerMock = Mockery::mock('alias:App\Services\Importer');
    }

    /** @test */
    public function it_dispatches_image_processing_job()
    {
        Storage::fake('local');
        Queue::fake();

        $fakeData = [
            ['product_code' => 'code123', 'quantity' => 10],
            ['product_code' => 'code456', 'quantity' => 15],
        ];

        Excel::shouldReceive('toArray')
            ->once()
            ->andReturn($fakeData);

        $spreadsheetService = new SpreadsheetService();
        $spreadsheetService->processSpreadsheet('fake-path/products.xlsx');

        Queue::assertPushed(ProcessProductImage::class, 2);
    }

    /** @test */
    public function it_creates_a_product_when_valid_data_is_provided()
    {
        Storage::fake('local');
        Queue::fake();

        $validData = [
            ['product_code' => 'code123', 'quantity' => 10],
        ];

        Excel::shouldReceive('toArray')
            ->once()
            ->andReturn($validData);

        $spreadsheetService = new SpreadsheetService();
        $spreadsheetService->processSpreadsheet('fake-path/products.xlsx');

        $this->assertDatabaseHas('products', [
            'product_code' => 'code123',
            'quantity' => 10,
        ]);

        Queue::assertPushed(ProcessProductImage::class, 1);
    }

    /** @test */
    public function it_skips_invalid_data()
    {
        Storage::fake('local');
        Queue::fake();

        $invalidData = [
            ['product_code' => '', 'quantity' => 10],
            ['product_code' => 'code456', 'quantity' => -5],
        ];

        Excel::shouldReceive('toArray')
            ->once()
            ->andReturn($invalidData);

        $spreadsheetService = new SpreadsheetService();
        $spreadsheetService->processSpreadsheet('fake-path/products.xlsx');

        $this->assertDatabaseMissing('products', [
            'product_code' => 'code456',
        ]);

        Queue::assertNotPushed(ProcessProductImage::class);
    }
}
