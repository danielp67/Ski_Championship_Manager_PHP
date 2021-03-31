<?php

use App\Repository\CategoryRepository;

beforeEach(function (){
      $pdo =  new stdClass;
       $this->categoryRepository = new CategoryRepository($pdo);
      });
      
it('test of instance', function(){
        $this->expect($this->categoryRepository)->toBeInstanceOf(CategoryRepository::class);
        });


it('should had properties', function(){
      $this->assertClassHasAttribute('pdo', CategoryRepository::class);
});

it('should had methods', function(){
      $this->expect(method_exists ($this->categoryRepository,  'find' ))->toBeTrue();
      $this->expect(method_exists ($this->categoryRepository,  'findbyName' ))->toBeTrue();
      $this->expect(method_exists ($this->categoryRepository,  'findAll' ))->toBeTrue();
      $this->expect(method_exists ($this->categoryRepository,  'add' ))->toBeTrue();
      $this->expect(method_exists ($this->categoryRepository,  'update' ))->toBeTrue();
      $this->expect(method_exists ($this->categoryRepository,  'delete' ))->toBeTrue();
        });
