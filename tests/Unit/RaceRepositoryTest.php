<?php

use App\Repository\ConnectRepository;
use App\Repository\RaceRepository;

beforeEach(function(){
        $pdo =  new stdClass;
       $this->raceRepository = new RaceRepository($pdo);
      });


it('test of instance', function(){
        $this->expect($this->raceRepository)->toBeInstanceOf(RaceRepository::class);
        });

it('should had properties', function(){
        $this->assertClassHasAttribute('pdo', RaceRepository::class);
        });

it('should had methods', function(){
        $this->expect(method_exists ($this->raceRepository,  'find' ))->toBeTrue();
        $this->expect(method_exists ($this->raceRepository,  'findAll' ))->toBeTrue();
        $this->expect(method_exists ($this->raceRepository,  'add' ))->toBeTrue();
        $this->expect(method_exists ($this->raceRepository,  'update' ))->toBeTrue();
        $this->expect(method_exists ($this->raceRepository,  'delete' ))->toBeTrue();
        });
