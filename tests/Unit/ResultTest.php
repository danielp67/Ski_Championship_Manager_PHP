<?php

use App\Model\Result;

beforeEach(function (){
       $this->result = new Result();
      });


it('test of instance', function(){
        $this->expect($this->result)->toBeInstanceOf(Result::class);
        $this->assertClassHasAttribute('id', Result::class);
        $this->assertClassHasAttribute('participantId', Result::class);
        $this->assertClassHasAttribute('raceId', Result::class);
        $this->assertClassHasAttribute('averageTime', Result::class);

        });
