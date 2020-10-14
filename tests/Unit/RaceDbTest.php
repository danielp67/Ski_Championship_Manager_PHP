<?php

use App\Model\RaceDb;

beforeEach(function (){
       $this->raceDb = new RaceDb();
      });


it('test of instance', function(){
        $this->expect($this->raceDb)->toBeInstanceOf(RaceDb::class);
        $this->assertClassHasAttribute('dataBase', RaceDb::class);
        $this->expect(method_exists ($this->raceDb,  'get' ))->toBeTrue();
        $this->expect(method_exists ($this->raceDb,  'getAll' ))->toBeTrue();
        $this->expect(method_exists ($this->raceDb,  'add' ))->toBeTrue();
        $this->expect(method_exists ($this->raceDb,  'update' ))->toBeTrue();
        $this->expect(method_exists ($this->raceDb,  'delete' ))->toBeTrue();

        });
