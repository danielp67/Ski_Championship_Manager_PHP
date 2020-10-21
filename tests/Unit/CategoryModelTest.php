<?php

use App\Repository\CategoryRepository;

beforeEach(function (){
       $this->categoryModel = new CategoryRepository();
      });
      
it('test of instance', function(){
        $this->expect($this->categoryModel)->toBeInstanceOf(CategoryRepository::class);
        });


it('should had properties', function(){
      $this->assertClassHasAttribute('dataBase', CategoryRepository::class);
});

it('should had methods', function(){
      $this->expect(method_exists ($this->categoryModel,  'find' ))->toBeTrue();
      $this->expect(method_exists ($this->categoryModel,  'findAll' ))->toBeTrue();
      $this->expect(method_exists ($this->categoryModel,  'add' ))->toBeTrue();
      $this->expect(method_exists ($this->categoryModel,  'update' ))->toBeTrue();
      $this->expect(method_exists ($this->categoryModel,  'delete' ))->toBeTrue();
        });
