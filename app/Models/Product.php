<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'description',
    'quantity',
    'user_id'
  ];

  /**
   * Seller of the product
   */
  public function seller()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Transactions of the product
   */
  public function transactions()
  {
    return $this->hasMany(Transaction::class);
  }

  public function getStatusAttribute()
  {
    return $this->quantity > 0 ? "In Stock" : "Sold Out";
  }

  public static function buy($id, $quantity)
  {
    $product = Product::find($id);
    $product->quantity = $product->quantity - $quantity;
    $product->save();
  }
}
