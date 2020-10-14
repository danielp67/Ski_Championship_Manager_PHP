<?php

use App\Model\Profile;

beforeEach(function (){
       $this->profile = new Profile();
      });


it('test of instance', function(){
        $this->expect($this->profile)->toBeInstanceOf(Profile::class);
        $this->assertClassHasAttribute('id', Profile::class);
        $this->assertClassHasAttribute('name', Profile::class);
        });

it('has setId', function($id){
    $this->expect($this->profile->setId($id))->toBeInstanceOf(Profile::class);
    $this->expect($id)->toBeInt();
})->with([
    0,1,3,5,7,10
]);

it('has setId throw exception', function($id){
    $this->profile->setId($id);
})->with([
    -1,-25
])->throws(Exception::class);


it('has setName', function($name){
    $pattern = '/^[a-zA-ZÀ-ÿ0-9 .-]{2,16}$/';
    $this->expect($this->profile->setName($name))->toBeInstanceOf(Profile::class);
    $this->assertMatchesRegularExpression($pattern, $name);
})->with('group');

it('has setName throw exception', function($name){
    $this->profile->setName($name);
})->with('failGroup')->throws(Exception::class);
