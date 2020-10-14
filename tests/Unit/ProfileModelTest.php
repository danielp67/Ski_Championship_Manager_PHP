<?php

use App\Model\ProfileModel;

beforeEach(function (){
       $this->profileModel = new ProfileModel();
      });


it('test of instance', function(){
        $this->expect($this->profileModel)->toBeInstanceOf(ProfileModel::class);
        $this->assertClassHasAttribute('dataBase', ProfileModel::class);
        $this->expect(method_exists ($this->profileModel,  'get' ))->toBeTrue();
        $this->expect(method_exists ($this->profileModel,  'getAll' ))->toBeTrue();
        $this->expect(method_exists ($this->profileModel,  'add' ))->toBeTrue();
        $this->expect(method_exists ($this->profileModel,  'update' ))->toBeTrue();
        $this->expect(method_exists ($this->profileModel,  'delete' ))->toBeTrue();

        });
