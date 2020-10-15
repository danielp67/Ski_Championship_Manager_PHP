<?php

use App\Model\ConnectModel;

beforeEach(function (){
       $this->connectModel = new ConnectModel();
      });


it('test of instance', function(){
        $this->expect($this->connectModel)->toBeInstanceOf(ConnectModel::class);
        });

it('should has methods', function(){
      $this->expect(method_exists ($this->connectModel,  'dbConnect' ))->toBeTrue();
      });
