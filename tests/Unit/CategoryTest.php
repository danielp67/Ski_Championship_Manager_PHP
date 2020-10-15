<?php

use App\Model\Category;

beforeEach(function (){
       $this->category = new Category();
      });


it('test of instance', function(){
        $this->expect($this->category)->toBeInstanceOf(Category::class);
});

it('should has properties', function(){
        $this->assertClassHasAttribute('id', Category::class);
        $this->assertClassHasAttribute('name', Category::class);
    });

it('should getId', function(){
    $this->category->setId(4);
    $this->expect($this->category->getId())->toBeInt();
});

it('should getName', function(){
    $this->category->setName('M1');
    $this->expect($this->category->getName())->toBeString();
});

it('has setId', function($id){
    $result = $this->category->setId($id);
    $this->expect($result->getId())->toEqual($id);
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
    $result = $this->category->setName($name);
    $this->expect($result->getName())->toEqual($name);
    $this->assertMatchesRegularExpression($pattern, $name);
})->with('group');

it('has setName throw exception', function($name){
    $this->category->setName($name);
})->with('failGroup')->throws(Exception::class);
