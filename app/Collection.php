<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = ['collection', 'size'];

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    static function getCollectionIdBySize(int $size)
    {
      $Ids  = Collection::where('size',$size)->select('id', 'collection')->get();
      return $Ids;
    }
}
