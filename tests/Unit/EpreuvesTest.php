<?php

use App\Model\Epreuves;

beforeEach(function(){
       $this->epreuve = new Epreuves();
      });


it('test of instance', function(){
        $this->expect($this->epreuve)->toBeInstanceOf(Epreuves::class);
        $this->assertClassHasAttribute('id', Epreuves::class);
        $this->assertClassHasAttribute('location', Epreuves::class);
        $this->assertClassHasAttribute('date', Epreuves::class);
        });


it('has setId', function($id){
    $this->expect($this->epreuve->setId($id))->toBeInstanceOf(Epreuves::class);
    $this->expect($id)->toBeInt();
})->with([
    0,1,3,5,7,10
]);

it('has setId throw exception', function($id){
    $this->epreuve->setId($id);
})->with([
    -1,-25
])->throws(Exception::class);


it('has setLocation', function($location){
    $pattern = '/^[a-zA-ZÀ-ÿ0-9 .-]{2,16}$/';
    $this->expect($this->epreuve->setLocation($location))->toBeInstanceOf(Epreuves::class);
    $this->assertMatchesRegularExpression($pattern, $location);
})->with('group');

it('has setName throw exception', function($location){
    $this->epreuve->setLocation($location);
})->with('failGroup')->throws(Exception::class);


it('has setDate', function($date){
    $pattern = '/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/';
    $this->expect($this->epreuve->setDate($date))->toBeInstanceOf(Epreuves::class);
    $this->assertMatchesRegularExpression($pattern, $date);
})->with([
    '01/01/1000',
    '31/12/2500'
]);

it('has setDate throw exception', function($date){
    $this->epreuve->setDate($date);
})->with([
    '01/01/10002',
    '31/32/2500'
])->throws(Exception::class);


