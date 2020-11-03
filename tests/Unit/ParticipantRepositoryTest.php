<?php

use App\Repository\ParticipantRepository;

beforeEach(function (){
      $pdo =  new stdClass;
       $this->participantRepository = new ParticipantRepository($pdo);
      });

it('test of instance', function(){
        $this->expect($this->participantRepository)->toBeInstanceOf(ParticipantRepository::class);
        });

it('should had properties', function(){
      $this->assertClassHasAttribute('pdo', ParticipantRepository::class);
});

it('should had methods', function(){
      $this->expect(method_exists ($this->participantRepository,  'find' ))->toBeTrue();
      $this->expect(method_exists ($this->participantRepository,  'findByName' ))->toBeTrue();
      $this->expect(method_exists ($this->participantRepository,  'findAllPaginated' ))->toBeTrue();
      $this->expect(method_exists ($this->participantRepository,  'add' ))->toBeTrue();
      $this->expect(method_exists ($this->participantRepository,  'update' ))->toBeTrue();
      $this->expect(method_exists ($this->participantRepository,  'delete' ))->toBeTrue();
});

