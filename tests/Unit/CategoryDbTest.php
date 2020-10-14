<?php

use App\Model\CategoryDb;

beforeEach(function (){
       $this->categoryDb = new CategoryDb();
      });


it('test of instance', function(){
        $this->expect($this->categoryDb)->toBeInstanceOf(CategoryDb::class);
        $this->assertClassHasAttribute('dataBase', CategoryDb::class);
        $this->expect(method_exists ($this->categoryDb,  'get' ))->toBeTrue();
        $this->expect(method_exists ($this->categoryDb,  'getAll' ))->toBeTrue();
        $this->expect(method_exists ($this->categoryDb,  'add' ))->toBeTrue();
        $this->expect(method_exists ($this->categoryDb,  'update' ))->toBeTrue();
        $this->expect(method_exists ($this->categoryDb,  'delete' ))->toBeTrue();

        });
