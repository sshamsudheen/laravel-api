<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Collection;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

  protected $collection;
  protected $product;
  protected $collectionIds;
  protected $collectionFields;

  public function __construct()
  {
      $this->collection       = array();
      $this->products         = array();
      $this->collectionIds    = array();
      $this->collectionFields = array('collection', 'size');
      $this->productFields    = array('image', 'name', 'sku');
  }
  public function index()
  {
      return Product::all();
  }

  public function show($id)
  {
      $products = Product::with('collection')->where('id',$id)->first();
      return $products;
  }

  // upload json file, check valid json format, convert to array, save in database
  public function store(Request $request)
  {

      $data=json_decode($request->getContent(), true);
      if (json_last_error() === JSON_ERROR_NONE)
      {
        foreach ($data as $key => $value)
        {
          $this->collection['collection']=$value['collection'];
          $this->collection['size']=$value['size'];

          // to check the uploaded json file has correct data in it for collection
          $validateCollectionData  = $this->validateCollectionData($this->collection, $this->collectionFields);
          if($validateCollectionData===false)
            return "Uploaded Json file has wrong data fields for colelction  \r\n";

          $collectionId = Collection::create($this->collection)->id;
          $this->products[$collectionId]  = $value['products'];
        }

        foreach($this->products as $key=>$product)
        {
          foreach($product as $individualProduct)
          {
            // to check the uploaded json file has correct data in it for product
            $validateCollectionData  = $this->validateCollectionData($individualProduct, $this->productFields);
            if($validateCollectionData===false)
              return "Uploaded Json file has wrong data fields for products  \r\n";


            $individualProduct['collection_id']=$key;
            Product::create($individualProduct);
          }
        }
        return 201;
      }
      else
        return "Wrong JSON format in uploaded file \n\r";
  }

  public function validateCollectionData(array $data, array $dataToCompare)
  {
    (array_keys($data) === $dataToCompare) ? $value  = true : $value= false;
    return $value;
  }

  public function update(Request $request, $id)
  {
      $article = Product::findOrFail($id);
      $article->update($request->all());

      return $article;
  }

  public function delete(Request $request, $id)
  {
      $article = Product::findOrFail($id);
      $article->delete();

      return 204;
  }

  public function getProductsBySize(int $size)
  {
    // get the collection id based on the size from collection model
    $collectionIds  = Collection::getCollectionIdBySize($size);
    foreach($collectionIds as $key=> $ids)
    {
      $this->collectionIds[]  = $ids['id'];
    }
    $products = Product::select('id','sku')->whereIn('collection_id',  $this->collectionIds)->get();
    return $products;
  }
}
