<?php

namespace App\Http\Controllers\apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Support\Facades\Auth;

class SellersController extends Controller
{
  /**
   * List all seller
   */
  public function list()
  {
    return $this->showAll(Seller::get()->toArray());
  }

  /**
   * List one seller
   *
   * @param $id to find
   */
  public function listOneSeller($id)
  {
    $seller = Seller::find($id);
    if (is_null($seller) || $seller->products()->count() == 0) {
      return $this->showError("El usuario especificado no es de tipo vendedor", [], 400);
    } else {
      return $this->showOne([
        'seller' => $seller,
        'products' => $seller->products()->get()
      ], 200);
    }
  }

  /**
   * Create product
   *
   * @param ProductRequest $request
   */
  public function storeProduct(ProductRequest $request)
  {
    $validator = $request->validator;
    if (count($validator->errors()) > 0) {
      return $this->showError("La petición debe cumplir con las validaciones correspondientes", $validator->errors()->all(), 400);
    }

    $data = $request->only(['name', 'description', 'quantity']);
    $data['user_id'] = Auth::user()->id;

    return $this->showOne(Product::create($data), 201);
  }
}
