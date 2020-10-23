<?php

use App\Entity\Race;

beforeEach(function(){
       $this->race = new Race();
      });

it('test of instance', function(){
        $this->expect($this->race)->toBeInstanceOf(Race::class);
        });

it('should had properties', function(){
        $this->assertClassHasAttribute('id', Race::class);
        $this->assertClassHasAttribute('location', Race::class);
        $this->assertClassHasAttribute('date', Race::class);
        $this->assertClassHasAttribute('status', Race::class);
        });

it('has setId', function($id){
    $result = $this->race->setId($id);
    $this->expect($result->getId())->toEqual($id);
})->with([
    0,1,3,5,7,10
]);

it('has setId throw exception', function($id){
    $this->race->setId($id);
})->with([
    -1,-25
])->throws(Exception::class);


it('has setLocation', function($location){
    $result = $this->race->setLocation($location);
    $this->expect($result->getLocation())->toEqual($location);
})->with('group');

it('has setName throw exception', function($location){
    $this->race->setLocation($location);
})->with('failGroup')->throws(Exception::class);


it('has setDate', function($date){
    $dateRace = DateTime::createFromFormat('Y-m-d', $date);
    $result = $this->race->setDate($date);
    $this->expect($result->getDate())->toEqual($dateRace);
})->with([
    '2020-12-31',
    '2500-01-01'
]);

it('has setDate throw exception', function($date){
    $this->race->setDate($date);
})->with([
    '01/01/10002',
    '31/32/2500'
])->throws(Exception::class);


it('has setStatus', function($status){
    $result = $this->race->setStatus($status);
    $this->expect($result->getStatus())->toEqual($status);
})->with([
    0,1,2,3
]);

it('has setStatus throw exception', function($status){
    $this->race->setStatus($status);
})->with([
    -1,4,5,-25
])->throws(Exception::class);
