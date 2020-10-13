<?php

use App\Model\CategoriesModel;

beforeEach(function (){
       $this->categoriesModel = new CategoriesModel();
      });


it('test of instance', function(){
        $this->expect($this->categoriesModel)->toBeInstanceOf(CategoriesModel::class);
        $this->assertClassHasAttribute('dataBase', CategoriesModel::class);
        $this->expect(method_exists ($this->categoriesModel,  'getCategorie' ))->toBeTrue();
        $this->expect(method_exists ($this->categoriesModel,  'getAllCategories' ))->toBeTrue();
        $this->expect(method_exists ($this->categoriesModel,  'addCategorie' ))->toBeTrue();
        $this->expect(method_exists ($this->categoriesModel,  'updateCategorie' ))->toBeTrue();
        $this->expect(method_exists ($this->categoriesModel,  'deleteCategorie' ))->toBeTrue();

        });
