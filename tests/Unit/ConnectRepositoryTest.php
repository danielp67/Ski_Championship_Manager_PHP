<?php

use App\Repository\ConnectRepository;


beforeEach(function (){
       $this->connectRepository = new ConnectRepository();
      });


it('test of instance', function(){
        $this->expect($this->connectRepository)->toBeInstanceOf(ConnectRepository::class);
        });

it('should had methods', function(){
      $this->expect(method_exists ($this->connectRepository,  'dbConnect' ))->toBeTrue();
      });
