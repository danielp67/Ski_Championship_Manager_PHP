
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

console.log(rankingList);

function remove(){
    for(let i = 0; i<rankingList.length; i++){

        rankingList[i].classList.add("inactive");
    }
}

remove();


let resultList = document.getElementById('resultList');

resultList.addEventListener("click", function(e) {
    let i = e.target.value
    remove();
    rankingList[i].classList.add("active");
    rankingList[i].classList.remove("inactive");
    console.log(e.target.value);
});
