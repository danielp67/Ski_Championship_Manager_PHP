<?php

use App\Model\CategoryModel;

beforeEach(function (){
       $this->categoryModel = new CategoryModel();
      });


it('test of instance', function(){
        $this->expect($this->categoryModel)->toBeInstanceOf(CategoryModel::class);
        });


it('should had properties', function(){
      $this->assertClassHasAttribute('dataBase', CategoryModel::class);
});

it('should had methods', function(){
      $this->expect(method_exists ($this->categoryModel,  'get' ))->toBeTrue();
      $this->expect(method_exists ($this->categoryModel,  'getAll' ))->toBeTrue();
      $this->expect(method_exists ($this->categoryModel,  'add' ))->toBeTrue();
      $this->expect(method_exists ($this->categoryModel,  'update' ))->toBeTrue();
      $this->expect(method_exists ($this->categoryModel,  'delete' ))->toBeTrue();
        });
