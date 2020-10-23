<?php

use App\Repository\RaceRepository;

beforeEach(function (){
       $this->raceRepository = new RaceRepository();
      });

it('test of instance', function(){
        $this->expect($this->raceRepository)->toBeInstanceOf(RaceRepository::class);
        });

it('should had properties', function(){
        $this->assertClassHasAttribute('dataBase', RaceRepository::class);
        });

it('should had methods', function(){
        $this->expect(method_exists ($this->raceRepository,  'find' ))->toBeTrue();
        $this->expect(method_exists ($this->raceRepository,  'findAll' ))->toBeTrue();
        $this->expect(method_exists ($this->raceRepository,  'add' ))->toBeTrue();
        $this->expect(method_exists ($this->raceRepository,  'update' ))->toBeTrue();
        $this->expect(method_exists ($this->raceRepository,  'delete' ))->toBeTrue();
        });
