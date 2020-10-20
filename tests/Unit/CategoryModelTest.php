<?php

use App\Repository\Category;

beforeEach(function (){
       $this->categoryModel = new Category();
      });
      
it('test of instance', function(){
        $this->expect($this->categoryModel)->toBeInstanceOf(Category::class);
        });


it('should had properties', function(){
      $this->assertClassHasAttribute('dataBase', Category::class);
});

it('should had methods', function(){
      $this->expect(method_exists ($this->categoryModel,  'find' ))->toBeTrue();
      $this->expect(method_exists ($this->categoryModel,  'findAll' ))->toBeTrue();
      $this->expect(method_exists ($this->categoryModel,  'add' ))->toBeTrue();
      $this->expect(method_exists ($this->categoryModel,  'update' ))->toBeTrue();
      $this->expect(method_exists ($this->categoryModel,  'delete' ))->toBeTrue();
        });
