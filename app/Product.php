<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['collection_id', 'image', 'name', 'sku'];

    public function collection()
    {
        return $this->belongsTo('App\Collection');
    }

    static function getProductInfoBySize($size)
    {
      // return all the products with same size
      return Product::whereIn('collection_id', [$size])->get();
    }
}
