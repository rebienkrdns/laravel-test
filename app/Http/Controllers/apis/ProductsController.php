<?php

namespace App\Http\Controllers\apis;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
  /**
   * List all products
   */
  public function list(Request $request)
  {
    $results = [];
    $products = Product::all();
    if ($request->has('show_products_without_stock')) {
      foreach ($products as $product) {
        // Set attribute status
        $product->status = $product->status;
        $results[] = $product;
      }
      return $this->showAll($results);
    } else {
      foreach ($products as $product) {
        if ($product->status == "In Stock") {
          // Set attribute status
          $product->status = $product->status;
          $results[] = $product;
        }
      }
      return $this->showAll($results);
    }
  }

  /**
   * Buy product
   */
  public function buy(Request $request, $id)
  {
    if ($request->quantity > Product::find($id)->quantity) {
      return $this->showError("La cantidad especificada supera la de stock", [], 400);
    } else {
      Product::buy($id, $request->quantity);

      return $this->showOne(Transaction::create(['quantity' => $request->quantity, 'user_id' => Auth::user()->id, 'product_id' => $id]), 201);
    }
  }
}
