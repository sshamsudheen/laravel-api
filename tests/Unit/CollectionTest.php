<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\Collection;

class CollectionTest extends TestCase
{

    public function testAddCollection()
    {
      $collectionData = array("collection"=>"Collectionname", "size"=>"28");
      $collectionId = Collection::create($collectionData)->id;
      $this->assertDatabaseHas('collections', ['collection' => 'Collectionname']);
      //Collection::where('id', $collection)->delete();
      return $collectionId;
    }


    /**
     * @depends testAddCollection
     *
     */
    public function testShow($collectionId)
    {
      $getCollectiondata=Collection::select('collection','size')->where('id',$collectionId)->get();
      $this->get('api/collections/'.$collectionId)
            ->assertStatus(200)->assertJson($getCollectiondata[0]->toArray());
    }


    /**
     * @depends testAddCollection
     *
     */
    public function testUpdate($collectionId)
    {
      $collectionData = array("collection"=>"CollectionnameUpdated");
      $collectionId = Collection::where('id',$collectionId)->update($collectionData);
      $this->assertDatabaseHas('collections', ['collection' => 'CollectionnameUpdated']);
      return $collectionId;
    }

    /**
     * @depends testUpdate
     *
     */
    public function testDelete($collectionId)
    {
       Collection::where('id',$collectionId)->delete();
       $this->assertDatabaseMissing('collections', ['id' => $collectionId]);
    }
}
