<?php

use App\Model\Race;

beforeEach(function(){
       $this->race = new Race();
      });


it('test of instance', function(){
        $this->expect($this->race)->toBeInstanceOf(Race::class);
        $this->assertClassHasAttribute('id', Race::class);
        $this->assertClassHasAttribute('location', Race::class);
        $this->assertClassHasAttribute('date', Race::class);
        });


it('has setId', function($id){
    $this->expect($this->race->setId($id))->toBeInstanceOf(Race::class);
    $this->expect($id)->toBeInt();
})->with([
    0,1,3,5,7,10
]);

it('has setId throw exception', function($id){
    $this->race->setId($id);
})->with([
    -1,-25
])->throws(Exception::class);


it('has setLocation', function($location){
    $pattern = '/^[a-zA-ZÀ-ÿ0-9 .-]{2,16}$/';
    $this->expect($this->race->setLocation($location))->toBeInstanceOf(Race::class);
    $this->assertMatchesRegularExpression($pattern, $location);
})->with('group');

it('has setName throw exception', function($location){
    $this->race->setLocation($location);
})->with('failGroup')->throws(Exception::class);


it('has setDate', function($date){
    $pattern = '/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/';
    $this->expect($this->race->setDate($date))->toBeInstanceOf(Race::class);
    $this->assertMatchesRegularExpression($pattern, $date);
})->with([
    '01/01/1000',
    '31/12/2500'
]);

it('has setDate throw exception', function($date){
    $this->race->setDate($date);
})->with([
    '01/01/10002',
    '31/32/2500'
])->throws(Exception::class);


