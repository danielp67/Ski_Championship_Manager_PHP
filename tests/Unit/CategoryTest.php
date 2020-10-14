<?php

use App\Model\Category;

beforeEach(function (){
       $this->category = new Category();
      });


it('test of instance', function(){
        $this->expect($this->category)->toBeInstanceOf(Category::class);
        $this->assertClassHasAttribute('id', Category::class);
        $this->assertClassHasAttribute('name', Category::class);
        });

it('has setId', function($id){
    $this->expect($this->category->setId($id))->toBeInstanceOf(Category::class);
    $this->expect($id)->toBeInt();
})->with([
    0,1,3,5,7,10
]);

it('has setId throw exception', function($id){
    $this->category->setId($id);
})->with([
    -1,-25
])->throws(Exception::class);


it('has setName', function($name){
    $pattern = '/^[a-zA-ZÀ-ÿ0-9 .-]{2,16}$/';
    $this->expect($this->category->setName($name))->toBeInstanceOf(Category::class);
    $this->assertMatchesRegularExpression($pattern, $name);
})->with('group');

it('has setName throw exception', function($name){
    $this->category->setName($name);
})->with('failGroup')->throws(Exception::class);
