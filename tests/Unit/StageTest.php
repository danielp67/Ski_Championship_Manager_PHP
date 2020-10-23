<?php

use App\Entity\Stage;

beforeEach(function (){
       $this->stage = new Stage();
      });


it('test of instance', function(){
        $this->expect($this->stage)->toBeInstanceOf(Stage::class);
        });

it('should has properties', function(){
        $this->assertClassHasAttribute('id', Stage::class);
        $this->assertClassHasAttribute('stageNb', Stage::class);
        $this->assertClassHasAttribute('time', Stage::class);
        $this->assertClassHasAttribute('participantId', Stage::class);
        $this->assertClassHasAttribute('raceId', Stage::class);
        });


it('should getId', function(){
    $this->stage->setId(4);
    $this->expect($this->stage->getId())->toBeInt();
});

it('should getStageNb', function(){
    $this->stage->setStageNb(1);
    $this->expect($this->stage->getStageNb())->toBeInt();
});

it('should getTime', function(){
    $timeStage = '01:00.0';
    $date = DateTime::createFromFormat('i:s.u', $timeStage);
    $this->stage->setTime($timeStage);
    $this->expect($this->stage->getTime())->toEqual($date);
});

it('should getParticipantId', function(){
    $this->stage->setParticipantId(4);
    $this->expect($this->stage->getParticipantId())->toBeInt();
});

it('should getRaceId', function(){
    $this->stage->setRaceId(4);
    $this->expect($this->stage->getRaceId())->toBeInt();
});



it('has setId', function($id){
    $result = $this->stage->setId($id);
    $this->expect($result->getId())->toEqual($id);
})->with([
    0,1,3,5,7,10
]);

it('has setId throw exception', function($id){
    $this->stage->setId($id);
})->with([
    -1,-25
])->throws(Exception::class);


it('has setStageNb', function($stageNb){
    $result = $this->stage->setStageNb($stageNb);
    $this->expect($result->getStageNb())->toEqual($stageNb);
})->with([
    1,2
]);

it('has setStageNb throw exception', function($stageNb){
    $this->stage->setStageNb($stageNb);
})->with([
    -1,0,3
])->throws(Exception::class);



it('has setTime', function($time){
    $timeStage = DateTime::createFromFormat('i:s.u', $time);
    $result = $this->stage->setTime($time);
    $this->expect($result->getTime())->toEqual($timeStage);
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
    $result = $this->stage->setParticipantId($participantId);
    $this->expect($result->getParticipantId())->toEqual($participantId);
})->with([
    0,1,3,5,7,10
]);

it('has setParticipantId throw exception', function($participantId){
    $this->stage->setParticipantId($participantId);
})->with([
    -1,-25
])->throws(Exception::class);


it('has setRaceId', function($raceId){
    $result = $this->stage->setRaceId($raceId);
    $this->expect($result->getRaceId())->toEqual($raceId);
})->with([
    0,1,3,5,7,10
]);

it('has setRaceId throw exception', function($raceId){
    $this->stage->setRaceId($raceId);
})->with([
    -1,-25
])->throws(Exception::class);
