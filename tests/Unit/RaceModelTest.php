<?php

use App\Model\RaceModel;

beforeEach(function (){
       $this->raceModel = new RaceModel();
      });


it('test of instance', function(){
        $this->expect($this->raceModel)->toBeInstanceOf(RaceModel::class);
        $this->assertClassHasAttribute('dataBase', RaceModel::class);
        $this->expect(method_exists ($this->raceModel,  'get' ))->toBeTrue();
        $this->expect(method_exists ($this->raceModel,  'getAll' ))->toBeTrue();
        $this->expect(method_exists ($this->raceModel,  'add' ))->toBeTrue();
        $this->expect(method_exists ($this->raceModel,  'update' ))->toBeTrue();
        $this->expect(method_exists ($this->raceModel,  'delete' ))->toBeTrue();

        });
