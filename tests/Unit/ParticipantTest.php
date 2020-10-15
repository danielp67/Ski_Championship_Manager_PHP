<?php

use App\Model\Participant;

beforeEach(function (){
       $this->participant = new Participant();
      });

it('test of instance', function(){
        $this->expect($this->participant)->toBeInstanceOf(Participant::class);
        });

it('should has properties', function(){
    $this->assertClassHasAttribute('id', Participant::class);
    $this->assertClassHasAttribute('lastName', Participant::class);
    $this->assertClassHasAttribute('firstName', Participant::class);
    $this->assertClassHasAttribute('mail', Participant::class);
    $this->assertClassHasAttribute('birthDate', Participant::class);
    $this->assertClassHasAttribute('imgLink', Participant::class);
    $this->assertClassHasAttribute('categoryId', Participant::class);
    $this->assertClassHasAttribute('profileId', Participant::class);
    });

it('should getId', function(){
    $this->participant->setId(4);
    $this->expect($this->participant->getId())->toBeInt();
});

it('should getLastName', function(){
    $this->participant->setLastName('M Durand');
    $this->expect($this->participant->getLastName())->toBeString();
});

it('should getFirstName', function(){
    $this->participant->setFirstName('Jean-Marc');
    $this->expect($this->participant->getFirstName())->toBeString();
});

it('should getMail', function(){
    $this->participant->setMail('jm.durand@gmail.com');
    $this->expect($this->participant->getMail())->toBeString();
});

it('should getImgLink', function(){
    $this->participant->setImgLink('test/img/durand.jpg');
    $this->expect($this->participant->getImgLink())->toBeString();
});

it('should getBirthDate', function(){
    $birthDate = '01/01/1000';
    $date = DateTime::createFromFormat('d/m/Y', $birthDate);
    $this->participant->setBirthDate($birthDate);
    $this->expect($this->participant->getBirthDate())->toEqual($date);
});

it('should getCategoryId', function(){
    $this->participant->setCategoryId(4);
    $this->expect($this->participant->getCategoryId())->toBeInt();
});

it('should getProfileId', function(){
    $this->participant->setProfileId(4);
    $this->expect($this->participant->getProfileId())->toBeInt();
});


it('has setId', function($id){
    $result = $this->participant->setId($id);
    $this->expect($result->getId())->toEqual($id);
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
    $result = $this->participant->setLastName($lastName);
    $this->expect($result->getLastName())->toEqual($lastName);
    $this->assertMatchesRegularExpression($pattern, $lastName);
})->with('name');

it('has setLastName throw exception', function($lastName){
    $this->participant->setLastName($lastName);
})->with('failName')->throws(Exception::class);


it('has setFirstName', function($firstName){
    $pattern = '/^[a-zA-ZÀ-ÿ .-]{2,16}$/';
    $result = $this->participant->setFirstName($firstName);
    $this->expect($result->getFirstName())->toEqual($firstName);
    $this->assertMatchesRegularExpression($pattern, $firstName);
})->with('name');

it('has setFirstName throw exception', function($firstName){
    $this->participant->setFirstName($firstName);
})->with('failName')->throws(Exception::class);


it('has setMail', function($mail){
    $pattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
    $result = $this->participant->setMail($mail);
    $this->expect($result->getMail())->toEqual($mail);
    $this->assertMatchesRegularExpression($pattern, $mail);
})->with('mail');

it('has setMail throw exception', function($mail){
    $this->participant->setMail($mail);
})->with('failMail')->throws(Exception::class);


it('has setBirthDate', function($birthDate){
    $pattern = '/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/';
    $date = DateTime::createFromFormat('d/m/Y', $birthDate);
    $result = $this->participant->setBirthDate($birthDate);
    $this->expect($result->getBirthDate())->toEqual($date);
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
    $result = $this->participant->setImgLink($imgLink);
    $this->expect($result->getImgLink())->toEqual($imgLink);
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
    $result = $this->participant->setCategoryId($categoryId);
    $this->expect($result->getCategoryId())->toEqual($categoryId);
})->with([
    0,1,3,5,7,10
]);

it('has setCategoryId throw exception', function($categoryId){
    $this->participant->setCategoryId($categoryId);
})->with([
    -1,-25
])->throws(Exception::class);


it('has setProfileId', function($profileId){
    $result = $this->participant->setProfileId($profileId);
    $this->expect($result->getProfileId())->toEqual($profileId);
})->with([
    0,1,3,5,7,10
]);

it('has setProfileId throw exception', function($profileId){
    $this->participant->setProfileId($profileId);
})->with([
    -1,-25
])->throws(Exception::class);
       