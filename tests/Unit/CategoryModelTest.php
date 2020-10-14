<?php

use App\Model\CategoryModel;

beforeEach(function (){
       $this->categoryModel = new CategoryModel();
      });


it('test of instance', function(){
        $this->expect($this->categoryModel)->toBeInstanceOf(CategoryModel::class);
        $this->assertClassHasAttribute('dataBase', CategoryModel::class);
        $this->expect(method_exists ($this->categoryModel,  'get' ))->toBeTrue();
        $this->expect(method_exists ($this->categoryModel,  'getAll' ))->toBeTrue();
        $this->expect(method_exists ($this->categoryModel,  'add' ))->toBeTrue();
        $this->expect(method_exists ($this->categoryModel,  'update' ))->toBeTrue();
        $this->expect(method_exists ($this->categoryModel,  'delete' ))->toBeTrue();

        });
