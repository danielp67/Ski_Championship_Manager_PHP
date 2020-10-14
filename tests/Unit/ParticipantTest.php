<?php

use App\Model\Participant;

beforeEach(function (){
       $this->participant = new Participant();
      });


it('test of instance', function(){
        $this->expect($this->participant)->toBeInstanceOf(Participant::class);
        $this->assertClassHasAttribute('id', Participant::class);
        $this->assertClassHasAttribute('lastName', Participant::class);
        $this->assertClassHasAttribute('firstName', Participant::class);
        $this->assertClassHasAttribute('mail', Participant::class);
        $this->assertClassHasAttribute('birthDate', Participant::class);
        $this->assertClassHasAttribute('imgLink', Participant::class);
        $this->assertClassHasAttribute('categoryId', Participant::class);
        $this->assertClassHasAttribute('profileId', Participant::class);
        });

it('has setId', function($id){
    $this->expect($this->participant->setId($id))->toBeInstanceOf(Participant::class);
    $this->expect($id)->toBeInt();
})->with([
    0,1,3,5,7,10
]);

it('has setId throw exception', function($id){
    $this->participant->setId($id);
})->with([
    -1,-25
])->throws(Exception::class);


it('has setLastName', function($lastName){
    $pattern = '/^[a-zA-ZÀ-ÿ .-]{2,16}$/';
    $this->expect($this->participant->setLastName($lastName))->toBeInstanceOf(Participant::class);
    $this->assertMatchesRegularExpression($pattern, $lastName);
})->with('name');

it('has setLastName throw exception', function($lastName){
    $this->participant->setLastName($lastName);
})->with('failName')->throws(Exception::class);


it('has setFirstName', function($firstName){
    $pattern = '/^[a-zA-ZÀ-ÿ .-]{2,16}$/';
    $this->expect($this->participant->setFirstName($firstName))->toBeInstanceOf(Participant::class);
    $this->assertMatchesRegularExpression($pattern, $firstName);
})->with('name');

it('has setFirstName throw exception', function($firstName){
    $this->participant->setFirstName($firstName);
})->with('failName')->throws(Exception::class);


it('has setMail', function($mail){
    $pattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
    $this->expect($this->participant->setMail($mail))->toBeInstanceOf(Participant::class);
    $this->assertMatchesRegularExpression($pattern, $mail);
})->with('mail');

it('has setMail throw exception', function($mail){
    $this->participant->setMail($mail);
})->with('failMail')->throws(Exception::class);


it('has setBirthDate', function($birthDate){
    $pattern = '/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/';
    $this->expect($this->participant->setBirthDate($birthDate))->toBeInstanceOf(Participant::class);
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
    $this->expect($this->participant->setImgLink($imgLink))->toBeInstanceOf(Participant::class);
    $this->assertMatchesRegularExpression($pattern, $imgLink);
})->with([
    '25.jpg',
    '/link/Img/45.JPEG'
]);

it('has setImgLink throw exception', function($imgLink){
    $this->participant->setImgLink($imgLink);
})->with([
    '25jpg',
    '/link/Img/45.JrG'
])->throws(Exception::class);


it('has setCategoryId', function($categoryId){
    $this->expect($this->participant->setCategoryId($categoryId))->toBeInstanceOf(Participant::class);
    $this->expect($categoryId)->toBeInt();
})->with([
    0,1,3,5,7,10
]);

it('has setCategoryId throw exception', function($categoryId){
    $this->participant->setCategoryId($categoryId);
})->with([
    -1,-25
])->throws(Exception::class);


it('has setProfileId', function($profileId){
    $this->expect($this->participant->setProfileId($profileId))->toBeInstanceOf(Participant::class);
    $this->expect($profileId)->toBeInt();
})->with([
    0,1,3,5,7,10
]);

it('has setProfileId throw exception', function($profileId){
    $this->participant->setProfileId($profileId);
})->with([
    -1,-25
])->throws(Exception::class);
       