<?php

use App\Model\Result;

beforeEach(function (){
       $this->result = new Result();
      });


it('test of instance', function(){
        $this->expect($this->result)->toBeInstanceOf(Result::class);
        });


it('should had properties', function(){
        $this->assertClassHasAttribute('id', Result::class);
        $this->assertClassHasAttribute('participantId', Result::class);
        $this->assertClassHasAttribute('raceId', Result::class);
        $this->assertClassHasAttribute('averageTime', Result::class);
        });


it('has setId', function($id){
    $result = $this->result->setId($id);
    $this->expect($result->getId())->toEqual($id);
})->with([
    0,1,3,5,7,10
]);

it('has setId throw exception', function($id){
    $this->result->setId($id);
})->with([
    -1,-25
])->throws(Exception::class);



it('has setParticipantId', function($participantId){
        $result = $this->result->setParticipantId($participantId);
        $this->expect($result->getParticipantId())->toEqual($participantId);
    })->with([
        0,1,3,5,7,10
    ]);
    
it('has setParticipantId throw exception', function($participantId){
        $this->result->setParticipantId($participantId);
    })->with([
        -1,-25
    ])->throws(Exception::class);



it('has setRaceId', function($raceId){
        $result = $this->result->setRaceId($raceId);
        $this->expect($result->getRaceId())->toEqual($raceId);
    })->with([
        0,1,3,5,7,10
    ]);
    
it('has setRaceId throw exception', function($raceId){
        $this->result->setRaceId($raceId);
    })->with([
        -1,-25
    ])->throws(Exception::class);
    

it('has setAverageTime', function($averageTime){
    $pattern = '/^([0-9]{1,2}:[0-5]{1}[0-9]{1}.[0-9]{1,3})$/';
    $timeStage = DateTime::createFromFormat('i:s.u', $averageTime);
    $result = $this->result->setAverageTime($averageTime);
    $this->expect($result->getAverageTime())->toEqual($timeStage);
    $this->assertMatchesRegularExpression($pattern, $averageTime);
})->with([
    '01:00.0',
    '99:59.999'
]);

it('has setAverageTime throw exception', function($averageTime){
    $this->result->setAverageTime($averageTime);
})->with([
    '1:01:0000',
    '99:60:99'
])->throws(Exception::class);