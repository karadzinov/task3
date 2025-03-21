<?php

namespace App\Services;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Jobs\ProcessProductImage;

class SpreadsheetService
{
    public function processSpreadsheet($filePath)
    {
        // Read the spreadsheet data
        $products_data = Excel::toArray(new ProductsImport, $filePath);

        foreach ($products_data as $row) {
            // Validate the row data
            $validator = Validator::make($row, [
                'product_code' => 'required|unique:products,code',
                'quantity' => 'required|integer|min:1',
            ]);

            // Skip invalid data
            if ($validator->fails()) {
                continue;
            }

            // Map validated data to match the database columns
            $validatedData = $validator->validated();
            $productData = [
                'product_code' => $validatedData['product_code'],  // Map 'product_code' to 'code'
                'quantity' => $validatedData['quantity'],
            ];

            // Debugging: Ensure 'product_code' and 'quantity' are being set properly
            \Log::debug('Product Data:', $productData);

            // Create the product
            $product = Product::create($productData);

            // Dispatch the image processing job
            ProcessProductImage::dispatch($product);
        }
    }


}





