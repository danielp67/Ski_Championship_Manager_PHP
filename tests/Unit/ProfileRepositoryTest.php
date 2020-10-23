<?php

use App\Repository\ProfileRepository;

beforeEach(function (){
       $this->profileRepository = new ProfileRepository();
      });


it('test of instance', function(){
        $this->expect($this->profileRepository)->toBeInstanceOf(ProfileRepository::class);
        });

        
it('should had properties', function(){
      $this->assertClassHasAttribute('dataBase', ProfileRepository::class);
});

it('should had methods', function(){
      $this->expect(method_exists ($this->profileRepository,  'find' ))->toBeTrue();
      $this->expect(method_exists ($this->profileRepository,  'findbyName' ))->toBeTrue();
      $this->expect(method_exists ($this->profileRepository,  'findAll' ))->toBeTrue();
      $this->expect(method_exists ($this->profileRepository,  'add' ))->toBeTrue();
      $this->expect(method_exists ($this->profileRepository,  'update' ))->toBeTrue();
      $this->expect(method_exists ($this->profileRepository,  'delete' ))->toBeTrue();
      });