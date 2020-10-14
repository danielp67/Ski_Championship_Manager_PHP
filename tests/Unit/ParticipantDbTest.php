<?php

use App\Model\ParticipantDb;

beforeEach(function (){
       $this->participantDb = new ParticipantDb();
      });


it('test of instance', function(){
        $this->expect($this->participantDb)->toBeInstanceOf(ParticipantDb::class);
        $this->assertClassHasAttribute('dataBase', ParticipantDb::class);
        $this->expect(method_exists ($this->participantDb,  'get' ))->toBeTrue();
        $this->expect(method_exists ($this->participantDb,  'getAll' ))->toBeTrue();
        $this->expect(method_exists ($this->participantDb,  'add' ))->toBeTrue();
        $this->expect(method_exists ($this->participantDb,  'update' ))->toBeTrue();
        $this->expect(method_exists ($this->participantDb,  'delete' ))->toBeTrue();

        });
