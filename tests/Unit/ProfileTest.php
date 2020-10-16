<?php

use App\Model\Profile;

beforeEach(function (){
       $this->profile = new Profile();
      });


it('test of instance', function(){
        $this->expect($this->profile)->toBeInstanceOf(Profile::class);
        });

it('should had properties', function(){
        $this->assertClassHasAttribute('id', Profile::class);
        $this->assertClassHasAttribute('name', Profile::class);
        });


it('should getId', function(){
    $this->profile->setId(4);
    $this->expect($this->profile->getId())->toBeInt();
});

it('should getName', function(){
    $this->profile->setName('ASVP');
    $this->expect($this->profile->getName())->toBeString();
});


it('has setId', function($id){
    $result = $this->profile->setId($id);
    $this->expect($result->getId())->toEqual($id);
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
    $result = $this->profile->setName($name);
    $this->expect($result->getName())->toEqual($name);
    $this->assertMatchesRegularExpression($pattern, $name);
})->with('group');

it('has setName throw exception', function($name){
    $this->profile->setName($name);
})->with('failGroup')->throws(Exception::class);
