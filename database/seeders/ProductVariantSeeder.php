<?php

namespace Database\Seeders;

use App\Models\ProductVariant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductVariant::insert([
            [
                'product_id' => '1',
                'variant_types' => '-;color;-',
                'variant_type_values' => '-;pink;-',
                'price' => '227.5',
                'on_sale' => '0',
                'sale_price' => '0',
                'quantity' => '6',
                'low_stock_value' => '4',
                'sku' => '',
                'status' => '1'
            ],
            [
                'product_id' => '1',
                'variant_types' => '-;color;-',
                'variant_type_values' => '-;light-blue;-',
                'price' => '228.5',
                'on_sale' => '0',
                'sale_price' => '0',
                'quantity' => '40',
                'low_stock_value' => '10',
                'sku' => '23423GHGT',
                'status' => '1'
            ],
            [
                'product_id' => '2',
                'variant_types' => '-;-;-',
                'variant_type_values' => '-;-;-',
                'price' => '269.5',
                'on_sale' => '1',
                'sale_price' => '250',
                'quantity' => '34',
                'low_stock_value' => '12',
                'sku' => '5235YYWET',
                'status' => '1'
            ],
            [
                'product_id' => '3',
                'variant_types' => '-;-;-',
                'variant_type_values' => '-;-',
                'price' => '880',
                'on_sale' => '1',
                'sale_price' => '800',
                'quantity' => '3',
                'low_stock_value' => '1',
                'sku' => '',
                'status' => '1'
            ],
            [
                'product_id' => '4',
                'variant_types' => '-;-;-',
                'variant_type_values' => '-;-;',
                'price' => '1300',
                'on_sale' => '1',
                'sale_price' => '1200',
                'quantity' => '2',
                'low_stock_value' => '1',
                'sku' => '',
                'status' => '1'
            ],
            [
                'product_id' => '6',
                'variant_types' => 'size;color;-',
                'variant_type_values' => '10;black;-',
                'price' => '53',
                'on_sale' => '0',
                'sale_price' => '0',
                'quantity' => '3',
                'low_stock_value' => '1',
                'sku' => '',
                'status' => '1'
            ],
            [
                'product_id' => '6',
                'variant_types' => 'size;color;-',
                'variant_type_values' => '12;black;-',
                'price' => '54',
                'on_sale' => '0',
                'sale_price' => '0',
                'quantity' => '5',
                'low_stock_value' => '1',
                'sku' => '',
                'status' => '1'
            ],
            [
                'product_id' => '6',
                'variant_types' => 'size;color;-',
                'variant_type_values' => '14;black;-',
                'price' => '55',
                'on_sale' => '0',
                'sale_price' => '0',
                'quantity' => '4',
                'low_stock_value' => '1',
                'sku' => '',
                'status' => '1'
            ],
            [
                'product_id' => '6',
                'variant_types' => 'size;color;-',
                'variant_type_values' => '16;black;-',
                'price' => '56',
                'on_sale' => '0',
                'sale_price' => '0',
                'quantity' => '3',
                'low_stock_value' => '1',
                'sku' => '',
                'status' => '1'
            ],
            [
                'product_id' => '7',
                'variant_types' => 'size;color;-',
                'variant_type_values' => '8;blue;-',
                'price' => '80',
                'on_sale' => '0',
                'sale_price' => '0',
                'quantity' => '4',
                'low_stock_value' => '1',
                'sku' => '',
                'status' => '1'
            ],
            [
                'product_id' => '7',
                'variant_types' => 'size;color;-',
                'variant_type_values' => '10;blue;-',
                'price' => '80',
                'on_sale' => '0',
                'sale_price' => '0',
                'quantity' => '4',
                'low_stock_value' => '1',
                'sku' => '',
                'status' => '1'
            ],
            [
                'product_id' => '7',
                'variant_types' => 'size;color;-',
                'variant_type_values' => '14;blue;-',
                'price' => '80',
                'on_sale' => '0',
                'sale_price' => '0',
                'quantity' => '2',
                'low_stock_value' => '1',
                'sku' => '',
                'status' => '1'
            ],
            [
                'product_id' => '7',
                'variant_types' => 'size;color;-',
                'variant_type_values' => '16;blue;-',
                'price' => '80',
                'on_sale' => '0',
                'sale_price' => '0',
                'quantity' => '6',
                'low_stock_value' => '1',
                'sku' => '',
                'status' => '1'
            ],
            [
                'product_id' => '8',
                'variant_types' => 'size;color;-',
                'variant_type_values' => '14;blue;-',
                'price' => '90',
                'on_sale' => '1',
                'sale_price' => '75',
                'quantity' => '8',
                'low_stock_value' => '2',
                'sku' => '',
                'status' => '1'
            ],
            [
                'product_id' => '9',
                'variant_types' => '-;-;-',
                'variant_type_values' => '-;-;-',
                'price' => '450',
                'on_sale' => '0',
                'sale_price' => '0',
                'quantity' => '2',
                'low_stock_value' => '1',
                'sku' => '',
                'status' => '1'
            ],
            [
                'product_id' => '10',
                'variant_types' => '-;-;-',
                'variant_type_values' => '-;-;-',
                'price' => '70',
                'on_sale' => '0',
                'sale_price' => '0',
                'quantity' => '4',
                'low_stock_value' => '1',
                'sku' => '',
                'status' => '1'
            ],
            [
                'product_id' => '7',
                'variant_types' => '-;-;-',
                'variant_type_values' => '-;-;-',
                'price' => '195',
                'on_sale' => '0',
                'sale_price' => '0',
                'quantity' => '2',
                'low_stock_value' => '-1',
                'sku' => '',
                'status' => '1'
            ],
            [
                'product_id' => '7',
                'variant_types' => '-;-;-',
                'variant_type_values' => '-;-;-',
                'price' => '4.5',
                'on_sale' => '1',
                'sale_price' => '3.4',
                'quantity' => '400',
                'low_stock_value' => '10',
                'sku' => '',
                'status' => '1'
            ],
            [
                'product_id' => '8',
                'variant_types' => '-;-;-',
                'variant_type_values' => '-;-;-',
                'price' => '2.85',
                'on_sale' => '1',
                'sale_price' => '2.75',
                'quantity' => '15',
                'low_stock_value' => '3',
                'sku' => '',
                'status' => '1'
            ],
            [
                'product_id' => '6',
                'variant_types' => 'size;color;-',
                'variant_type_values' => '12;pink;-',
                'price' => '5.4',
                'on_sale' => '0',
                'sale_price' => '0',
                'quantity' => '7',
                'low_stock_value' => '2',
                'sku' => '',
                'status' => '1'
            ],
            [
                'product_id' => '6',
                'variant_types' => 'size;color;-',
                'variant_type_values' => '14;pink;-',
                'price' => '55',
                'on_sale' => '0',
                'sale_price' => '0',
                'quantity' => '9',
                'low_stock_value' => '3',
                'sku' => '',
                'status' => '1'
            ]
        ]);
    }
}
