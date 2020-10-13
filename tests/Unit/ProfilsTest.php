<?php

use App\Model\Profils;

beforeEach(function (){
       $this->profil = new Profils();
      });


it('test of instance', function(){
        $this->expect($this->profil)->toBeInstanceOf(Profils::class);
        $this->assertClassHasAttribute('id', Profils::class);
        $this->assertClassHasAttribute('name', Profils::class);
        });

it('has setId', function($id){
    $this->expect($this->profil->setId($id))->toBeInstanceOf(Profils::class);
    $this->expect($id)->toBeInt();
})->with([
    0,1,3,5,7,10
]);

it('has setId throw exception', function($id){
    $this->profil->setId($id);
})->with([
    -1,-25
])->throws(Exception::class);


it('has setName', function($name){
    $pattern = '/^[a-zA-ZÀ-ÿ0-9 .-]{2,16}$/';
    $this->expect($this->profil->setName($name))->toBeInstanceOf(Profils::class);
    $this->assertMatchesRegularExpression($pattern, $name);
})->with('group');

it('has setName throw exception', function($name){
    $this->profil->setName($name);
})->with('failGroup')->throws(Exception::class);
