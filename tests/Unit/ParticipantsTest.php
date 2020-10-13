<?php

use App\Model\Participants;

beforeEach(function (){
       $this->participant = new Participants();
      });


it('test of instance', function(){
        $this->expect($this->participant)->toBeInstanceOf(Participants::class);
        $this->assertClassHasAttribute('lastName', Participants::class);
        $this->assertClassHasAttribute('firstName', Participants::class);
        $this->assertClassHasAttribute('mail', Participants::class);
        $this->assertClassHasAttribute('birthDate', Participants::class);
        $this->assertClassHasAttribute('imgLink', Participants::class);
        $this->assertClassHasAttribute('categoriesId', Participants::class);
        $this->assertClassHasAttribute('profilsId', Participants::class);
        });


it('has setLastName', function($lastName){
    $pattern = '/^[a-zA-ZÀ-ÿ .-]{2,16}$/';
    $this->expect($this->participant->setLastName($lastName))->toBeInstanceOf(Participants::class);
    $this->assertMatchesRegularExpression($pattern, $lastName);
})->with('name');

it('has setLastName throw exception', function($lastName){
    $this->participant->setLastName($lastName);
})->with('failName')->throws(Exception::class);


it('has setFirstName', function($firstName){
    $pattern = '/^[a-zA-ZÀ-ÿ .-]{2,16}$/';
    $this->expect($this->participant->setFirstName($firstName))->toBeInstanceOf(Participants::class);
    $this->assertMatchesRegularExpression($pattern, $firstName);
})->with('name');

it('has setFirstName throw exception', function($firstName){
    $this->participant->setFirstName($firstName);
})->with('failName')->throws(Exception::class);


it('has setMail', function($mail){
    $pattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
    $this->expect($this->participant->setMail($mail))->toBeInstanceOf(Participants::class);
    $this->assertMatchesRegularExpression($pattern, $mail);
})->with('mail');

it('has setMail throw exception', function($mail){
    $this->participant->setMail($mail);
})->with('failMail')->throws(Exception::class);


it('has setBirthDate', function($birthDate){
    $pattern = '/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/';
    $this->expect($this->participant->setBirthDate($birthDate))->toBeInstanceOf(Participants::class);
    $this->assertMatchesRegularExpression($pattern, $birthDate);
})->with([
    '01/01/1000',
    '31/12/2500'
]);

it('has setBirthDate throw exception', function($birthDate){
    $this->participant->setBirthDate($birthDate);
})->with([
    '01/01/10002',
    '31/32/2500'
])->throws(Exception::class);


it('has setImgLink', function($imgLink){
    $pattern = '/([^\\s]+(\\.(?i)(jpe?g|png|gif|bmp))$)/';
    $this->expect($this->participant->setImgLink($imgLink))->toBeInstanceOf(Participants::class);
    $this->assertMatchesRegularExpression($pattern, $imgLink);
})->with([
    '25.jpg',
    '/link/Img/45.JPEG'
]);

it('has setImgLink throw exception', function($imgLink){
    $this->participant->setImgLink($imgLink);
})->with([
    '25jpg',
    '/link/Img/45.JRG'
])->throws(Exception::class);

       