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
        $this->assertClassHasAttribute('resultId', Stage::class);
        $this->assertClassHasAttribute('stageNb', Stage::class);
        $this->assertClassHasAttribute('time', Stage::class);
        });


it('should getId', function(){
    $this->stage->setId(4);
    $this->expect($this->stage->getId())->toBeInt();
});

it('should getResultId', function(){
    $this->stage->setResultId(4);
    $this->expect($this->stage->getResultId())->toBeInt();
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

it('has setResultId', function($resultId){
    $result = $this->stage->setResultId($resultId);
    $this->expect($result->getResultId())->toEqual($resultId);
})->with([
    0,1,3,5,7,10
]);

it('has setResultId throw exception', function($resultId){
    $this->stage->setResultId($resultId);
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

