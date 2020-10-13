<?php

use App\Model\ParticipantsModel;

beforeEach(function (){
       $this->participantsModel = new ParticipantsModel();
      });


it('test of instance', function(){
        $this->expect($this->participantsModel)->toBeInstanceOf(ParticipantsModel::class);
        $this->assertClassHasAttribute('dataBase', ParticipantsModel::class);
        $this->expect(method_exists ($this->participantsModel,  'getParticipant' ))->toBeTrue();
        $this->expect(method_exists ($this->participantsModel,  'getAllParticipants' ))->toBeTrue();
        $this->expect(method_exists ($this->participantsModel,  'addParticipant' ))->toBeTrue();
        $this->expect(method_exists ($this->participantsModel,  'updateParticipant' ))->toBeTrue();
        $this->expect(method_exists ($this->participantsModel,  'deleteParticipant' ))->toBeTrue();

        });
