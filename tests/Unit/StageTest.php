<?php

use App\Model\Stage;

beforeEach(function (){
       $this->stage = new Stage();
      });


it('test of instance', function(){
        $this->expect($this->stage)->toBeInstanceOf(Stage::class);
        $this->assertClassHasAttribute('id', Stage::class);
        $this->assertClassHasAttribute('stage', Stage::class);
        $this->assertClassHasAttribute('time', Stage::class);
        $this->assertClassHasAttribute('participantId', Stage::class);
        $this->assertClassHasAttribute('raceId', Stage::class);
        });

it('has setId', function($id){
    $this->expect($this->stage->setId($id))->toBeInstanceOf(Stage::class);
    $this->expect($id)->toBeInt();
})->with([
    0,1,3,5,7,10
]);

it('has setId throw exception', function($id){
    $this->stage->setId($id);
})->with([
    -1,-25
])->throws(Exception::class);


it('has setStage', function($stage){
    $this->expect($this->stage->setStage($stage))->toBeInstanceOf(Stage::class);
    $this->expect($stage)->toBeInt();
})->with([
    1,2
]);

it('has setStage throw exception', function($stage){
    $this->stage->setStage($stage);
})->with([
    -1,0,3
])->throws(Exception::class);



it('has setTime', function($time){
    $pattern = '/^([0-9]{1,2}:[0-5]{1}[0-9]{1}.[0-9]{1,3})$/';
    $this->expect($this->stage->setTime($time))->toBeInstanceOf(Stage::class);
    $this->assertMatchesRegularExpression($pattern, $time);
})->with([
    '01:00.0',
    '99:59.999'
]);

it('has setTime throw exception', function($time){
    $this->stage->setTime($time);
})->with([
    '1:01:0000',
    '99:60:99'
])->throws(Exception::class);


it('has setParticipantId', function($participantId){
    $this->expect($this->stage->setParticipantId($participantId))->toBeInstanceOf(Stage::class);
    $this->expect($participantId)->toBeInt();
})->with([
    0,1,3,5,7,10
]);

it('has setParticipantId throw exception', function($participantId){
    $this->stage->setParticipantId($participantId);
})->with([
    -1,-25
])->throws(Exception::class);


it('has setRaceId', function($raceId){
    $this->expect($this->stage->setRaceId($raceId))->toBeInstanceOf(Stage::class);
    $this->expect($raceId)->toBeInt();
})->with([
    0,1,3,5,7,10
]);

it('has setRaceId throw exception', function($raceId){
    $this->stage->setRaceId($raceId);
})->with([
    -1,-25
])->throws(Exception::class);
