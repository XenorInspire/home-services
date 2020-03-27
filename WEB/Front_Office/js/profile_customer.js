function enable() {

    let section = document.getElementsByClassName('container')[0];
    let button = section.getElementsByClassName('btn')[0];
    let newButton = document.createElement('button');
    let inputs = section.getElementsByTagName('input');

    button.innerHTML = "Valider";
    button.onclick = validate;

    for (let i = 0; i < inputs.length; i++) {

        inputs[i].disabled = false;
        inputs[i].style.border = "#80bdff";
        inputs[i].style.boxShadow = "0 0 0 2px rgba(0,123,255,.25)";

    }


    newButton.innerHTML = "Annuler";
    newButton.onclick = cancel;
    newButton.className = "btn btn-dark";
    section.appendChild(newButton);

}

function validate() {

    console.log('test');

}

function cancel() {

    let section = document.getElementsByClassName('container')[0];
    let inputs = section.getElementsByTagName('input');
    let button = section.getElementsByClassName('btn')[0];
    let oldButton = section.getElementsByClassName('btn')[1];

    button.innerHTML = "Modifier mes informations";
    button.onclick = enable;

    for (let i = 0; i < inputs.length; i++) {

        inputs[i].style.border = "1px solid #ced4da";
        inputs[i].style.boxShadow = "";
        inputs[i].disabled = true;

    }

    section.removeChild(oldButton);

}

function enablePasswd() {

    let section = document.getElementsByClassName('container')[1];
    let button = section.getElementsByClassName('btn')[0];
    let newButton = document.createElement('button');
    let inputs = section.getElementsByTagName('input');

    button.innerHTML = "Valider";
    button.onclick = validatePasswd;

    for (let i = 0; i < inputs.length; i++) {

        inputs[i].disabled = false;
        inputs[i].style.border = "#80bdff";
        inputs[i].style.boxShadow = "0 0 0 2px rgba(0,123,255,.25)";

    }


    newButton.innerHTML = "Annuler";
    newButton.onclick = cancelPasswd;
    newButton.className = "btn btn-dark";
    section.appendChild(newButton);

}

function validatePasswd() {

    console.log('test');

}

function cancelPasswd() {

    let section = document.getElementsByClassName('container')[1];
    let inputs = section.getElementsByTagName('input');
    let button = section.getElementsByClassName('btn')[0];
    let oldButton = section.getElementsByClassName('btn')[1];

    button.innerHTML = "Modifier mes informations";
    button.onclick = enablePasswd;

    for (let i = 0; i < inputs.length; i++) {

        inputs[i].style.border = "1px solid #ced4da";
        inputs[i].style.boxShadow = "";
        inputs[i].disabled = true;

    }

    section.removeChild(oldButton);

}