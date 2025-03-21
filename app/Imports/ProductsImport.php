<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class ProductsImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        return new Product([
            'product_code' => $row['product_code'],
            'quantity' => $row['quantity'],
        ]);
    }

    public function onFailure(\Maatwebsite\Excel\Validators\Failure ...$failures)
    {
        // Handle failures here (like logging the failed rows)
    }
}
