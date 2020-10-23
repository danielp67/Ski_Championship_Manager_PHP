<?php

use App\Repository\ParticipantRepository;

beforeEach(function (){
       $this->participantRepository = new ParticipantRepository();
      });

it('test of instance', function(){
        $this->expect($this->participantRepository)->toBeInstanceOf(ParticipantRepository::class);
        });

it('should had properties', function(){
      $this->assertClassHasAttribute('dataBase', ParticipantRepository::class);
});

it('should had methods', function(){
      $this->expect(method_exists ($this->participantRepository,  'find' ))->toBeTrue();
      $this->expect(method_exists ($this->participantRepository,  'findByName' ))->toBeTrue();
      $this->expect(method_exists ($this->participantRepository,  'findAll' ))->toBeTrue();
      $this->expect(method_exists ($this->participantRepository,  'add' ))->toBeTrue();
      $this->expect(method_exists ($this->participantRepository,  'update' ))->toBeTrue();
      $this->expect(method_exists ($this->participantRepository,  'delete' ))->toBeTrue();
});

