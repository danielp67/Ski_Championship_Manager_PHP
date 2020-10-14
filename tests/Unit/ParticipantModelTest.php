<?php

use App\Model\ParticipantModel;

beforeEach(function (){
       $this->participantModel = new ParticipantModel();
      });


it('test of instance', function(){
        $this->expect($this->participantModel)->toBeInstanceOf(ParticipantModel::class);
        $this->assertClassHasAttribute('dataBase', ParticipantModel::class);
        $this->expect(method_exists ($this->participantModel,  'get' ))->toBeTrue();
        $this->expect(method_exists ($this->participantModel,  'getAll' ))->toBeTrue();
        $this->expect(method_exists ($this->participantModel,  'add' ))->toBeTrue();
        $this->expect(method_exists ($this->participantModel,  'update' ))->toBeTrue();
        $this->expect(method_exists ($this->participantModel,  'delete' ))->toBeTrue();

        });
