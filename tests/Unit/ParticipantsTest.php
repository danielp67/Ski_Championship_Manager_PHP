<?php

use App\Model\Participants;

beforeEach(function (){
       $this->participant = new Participants();
      });


it('test of instance', function(){
        $this->expect($this->participant)->toBeInstanceOf(Participants::class);
        $this->assertClassHasAttribute('id', Participants::class);
        $this->assertClassHasAttribute('lastName', Participants::class);
        $this->assertClassHasAttribute('firstName', Participants::class);
        $this->assertClassHasAttribute('mail', Participants::class);
        $this->assertClassHasAttribute('birthDate', Participants::class);
        $this->assertClassHasAttribute('imgLink', Participants::class);
        $this->assertClassHasAttribute('categoriesId', Participants::class);
        $this->assertClassHasAttribute('profilsId', Participants::class);
        });

it('has setId', function($id){
    $this->expect($this->participant->setId($id))->toBeInstanceOf(Participants::class);
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
    '/link/Img/45.JrG'
])->throws(Exception::class);


it('has setCategoriesId', function($categoriesId){
    $this->expect($this->participant->setCategoriesId($categoriesId))->toBeInstanceOf(Participants::class);
    $this->expect($categoriesId)->toBeInt();
})->with([
    0,1,3,5,7,10
]);

it('has setCategoriesId throw exception', function($categoriesId){
    $this->participant->setCategoriesId($categoriesId);
})->with([
    -1,-25
])->throws(Exception::class);


it('has setProfilsId', function($profilsId){
    $this->expect($this->participant->setProfilsId($profilsId))->toBeInstanceOf(Participants::class);
    $this->expect($profilsId)->toBeInt();
})->with([
    0,1,3,5,7,10
]);

it('has setProfilsId throw exception', function($profilsId){
    $this->participant->setProfilsId($profilsId);
})->with([
    -1,-25
])->throws(Exception::class);
       