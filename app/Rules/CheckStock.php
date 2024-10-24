<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckStock implements ValidationRule
{
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($this->products as $productData) {
            $product = Product::find($productData['id']);
            if (!$product || $product->stock < $productData['quantity']) {
                $fail('One or more products do not have sufficient stock.');
            }
        }
    }
}
