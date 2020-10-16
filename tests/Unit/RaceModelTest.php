<?php

use App\Model\RaceModel;

beforeEach(function (){
       $this->raceModel = new RaceModel();
      });

it('test of instance', function(){
        $this->expect($this->raceModel)->toBeInstanceOf(RaceModel::class);
        });

it('should had properties', function(){
        $this->assertClassHasAttribute('dataBase', RaceModel::class);
        });

it('should had methods', function(){
        $this->expect(method_exists ($this->raceModel,  'get' ))->toBeTrue();
        $this->expect(method_exists ($this->raceModel,  'getAll' ))->toBeTrue();
        $this->expect(method_exists ($this->raceModel,  'add' ))->toBeTrue();
        $this->expect(method_exists ($this->raceModel,  'update' ))->toBeTrue();
        $this->expect(method_exists ($this->raceModel,  'delete' ))->toBeTrue();
        });
