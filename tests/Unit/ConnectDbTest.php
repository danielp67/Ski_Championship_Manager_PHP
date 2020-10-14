<?php

use App\Model\ConnectDb;

beforeEach(function (){
       $this->connectDb = new ConnectDb();
      });


it('test of instance', function(){
        $this->expect($this->connectDb)->toBeInstanceOf(ConnectDb::class);
        $this->expect(method_exists ($this->connectDb,  'dbConnect' ))->toBeTrue();
        });
