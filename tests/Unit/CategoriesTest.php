<?php

use App\Model\Categories;

beforeEach(function (){
       $this->categorie = new Categories();
      });


it('test of instance', function(){
        $this->expect($this->categorie)->toBeInstanceOf(Categories::class);
        $this->assertClassHasAttribute('id', Categories::class);
        $this->assertClassHasAttribute('name', Categories::class);
        });

it('has setId', function($id){
    $this->expect($this->categorie->setId($id))->toBeInstanceOf(Categories::class);
    $this->expect($id)->toBeInt();
})->with([
    0,1,3,5,7,10
]);

it('has setId throw exception', function($id){
    $this->categorie->setId($id);
})->with([
    -1,-25
])->throws(Exception::class);


it('has setName', function($name){
    $pattern = '/^[a-zA-ZÀ-ÿ0-9 .-]{2,16}$/';
    $this->expect($this->categorie->setName($name))->toBeInstanceOf(Categories::class);
    $this->assertMatchesRegularExpression($pattern, $name);
})->with('group');

it('has setName throw exception', function($name){
    $this->categorie->setName($name);
})->with('failGroup')->throws(Exception::class);
