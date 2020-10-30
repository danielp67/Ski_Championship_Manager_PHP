
// Profile and Category View
let formAdd = document.getElementById('formAdd');
let formUpdate = document.getElementById('formUpdate');

let buttonAdd = document.getElementById('buttonAdd');
let buttonUpdate = document.getElementById('buttonUpdate');
let buttonDelete = document.getElementById('buttonDelete');

let buttonHide1 = document.getElementById('buttonHide1');
let buttonHide2 = document.getElementById('buttonHide2');

let groupList = document.getElementById('groupList');
let nameId = document.getElementById('nameId');
let nameIdmod = document.getElementById('nameIdmod');


function hiddenForm(){
    formAdd.classList.add("inactive");
    formUpdate.classList.add("inactive");

}

if(formAdd !== null || formUpdate !== null){
    hiddenForm();

    buttonAdd.addEventListener("click", function(e) {
        e.preventDefault();
        formAdd.classList.toggle("active");
        formAdd.classList.toggle("inactive");
        formUpdate.classList.add("inactive");
    
    });
    
    
    buttonUpdate.addEventListener("click", function(e) {
        e.preventDefault();
        formUpdate.classList.toggle("active");
        formUpdate.classList.toggle("inactive");
        formAdd.classList.add("inactive");
    
    });
    
    buttonHide1.addEventListener("click", function(e) {
        e.preventDefault();
        hiddenForm();
    });
    
    buttonHide2.addEventListener("click", function(e) {
        e.preventDefault();
        hiddenForm();
    });
    
    groupList.addEventListener("click", function(e) {
       
        buttonUpdate.disabled = false;
        buttonDelete.disabled = false;
        nameId.value = e.target.value;
        nameIdmod.value = e.target.value;
    
        console.log(e.target);
    });

}





// For Result View

let rankingList = document.getElementsByClassName('rankingList');
let resultList = document.getElementById('resultList');

function remove(){
    for(let i = 0; i<rankingList.length; i++){

        rankingList[i].classList.add("inactive");
    }
}

if(resultList !== null){

    remove();

    resultList.addEventListener("click", function(e) {
        let i = e.target.value;
        remove();
        rankingList[i].classList.add("active");
        rankingList[i].classList.remove("inactive");
        console.log(e.target.value);
    });

}

// For Add participant List View

let notParticipants = document.getElementById('notParticipants');
let participants = document.getElementById('participants');

let listNotParticipants = notParticipants.getElementsByTagName('option');
let listParticipants = participants.getElementsByTagName('option');

let addParticipant = document.getElementById('buttonAdd');
let removeParticipant = document.getElementById('buttonRemove');
let addAllParticipant = document.getElementById('buttonAddAll');
let removeAllParticipant = document.getElementById('buttonRemoveAll');
let submitParticipant = document.getElementById('buttonSubmit');

let raceId = document.getElementById('raceId').value;

let selectedIdNotParticipant = '';
let selectedIdParticipant = '';
let idNotParticipants = [];
let idParticipants = [];

console.log(idParticipants.length);
participants.addEventListener("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        selectedIdParticipant = e.target;
});

notParticipants.addEventListener("click", function(e){
    e.preventDefault();
    e.stopPropagation();
    selectedIdNotParticipant = e.target;
});

addParticipant.addEventListener("click", function(e){
    e.preventDefault();
    e.stopPropagation();
    setListParticipantAndNotParticipant();
    if(listNotParticipants.length > 0){
    addParticipantList(selectedIdNotParticipant);
    }
});

removeParticipant.addEventListener("click", function(e){
    e.preventDefault();
    e.stopPropagation();
    setListParticipantAndNotParticipant();
    if(listParticipants.length > 0){
        removeParticipantList(selectedIdParticipant);
    }
});

function addParticipantList(id){
    participants.append(id);
    console.log(listNotParticipants);

}

function removeParticipantList(id){
    notParticipants.append(id);
    console.log(listNotParticipants);

}

function setListParticipantAndNotParticipant(){
    for(let i = 0; i<listNotParticipants.length; i++){
        idNotParticipants.push(listNotParticipants[i].value);
    }
    
    for(let i = 0; i<listParticipants.length; i++){
        idParticipants.push(listParticipants[i].value);
    }
    
}

submitParticipant.addEventListener("click", function(e){
    e.preventDefault();
    e.stopPropagation();
    setListParticipantAndNotParticipant();

idParticipants.sort(function(a, b) {
  return a - b;
});

console.log(idParticipants);
let formData = new FormData();
formData.append('participantId', idParticipants);
fetch('http://127.1.2.3/result/'+raceId+'/addParticipantList', {method: 'POST', body: formData})
.then(res => {
    console.log(res);
    if(res.status === 200){
        console.log('ok');
        window.location.replace("http://127.1.2.3/race/"+raceId+'/detail');

    }
    else{
        console.log('erreur');
    }
} );

});