<?php

use App\Model\Race;

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
        });

it('should getId', function(){
    $this->race->setId(4);
    $this->expect($this->race->getId())->toBeInt();
});

it('should getLocation', function(){
    $this->race->setLocation('Isola 2000');
    $this->expect($this->race->getLocation())->toBeString();
});

it('should getDate', function(){
    $dateLocation = '01/01/1000';
    $date = DateTime::createFromFormat('d/m/Y', $dateLocation);
    $this->race->setDate($dateLocation);
    $this->expect($this->race->getDate())->toEqual($date);
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
    $dateRace = DateTime::createFromFormat('d/m/Y', $date);
    $result = $this->race->setDate($date);
    $this->expect($result->getDate())->toEqual($dateRace);
})->with([
    '01/01/2200',
    '31/12/2500'
]);

it('has setDate throw exception', function($date){
    $this->race->setDate($date);
})->with([
    '01/01/10002',
    '31/32/2500'
])->throws(Exception::class);


