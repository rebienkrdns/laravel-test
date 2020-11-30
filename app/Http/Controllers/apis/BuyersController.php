<?php

namespace App\Http\Controllers\apis;

use App\Http\Controllers\Controller;
use App\Models\Buyer;

class BuyersController extends Controller
{
  /**
   * List all buyers
   */
  public function list()
  {
    return $this->showAll(Buyer::get()->toArray());
  }

  /**
   * List one buyer
   *
   * @param $id to find
   */
  public function listOneBuyer($id)
  {
    $buyer = Buyer::find($id);
    if (is_null($buyer) || $buyer->transactions()->count() == 0) {
      return $this->showError("El usuario especificado no es de tipo comprador", [], 400);
    } else {
      return $this->showOne([
        'buyer' => $buyer,
        'transactions' => $buyer->transactions()->get()
      ], 200);
    }
  }
}
