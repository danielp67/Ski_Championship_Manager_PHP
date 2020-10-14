<?php

use App\Model\ProfileDb;

beforeEach(function (){
       $this->profileDb = new ProfileDb();
      });


it('test of instance', function(){
        $this->expect($this->profileDb)->toBeInstanceOf(ProfileDb::class);
        $this->assertClassHasAttribute('dataBase', ProfileDb::class);
        $this->expect(method_exists ($this->profileDb,  'get' ))->toBeTrue();
        $this->expect(method_exists ($this->profileDb,  'getAll' ))->toBeTrue();
        $this->expect(method_exists ($this->profileDb,  'add' ))->toBeTrue();
        $this->expect(method_exists ($this->profileDb,  'update' ))->toBeTrue();
        $this->expect(method_exists ($this->profileDb,  'delete' ))->toBeTrue();

        });
