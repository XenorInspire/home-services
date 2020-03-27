var cid;

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

    let section = document.getElementsByClassName('container')[0];
    let firstname = document.getElementsByName('firstname')[0].value;
    let lastname = document.getElementsByName('lastname')[0].value;
    let mail = document.getElementsByName('mail')[0].value;
    let phone_number = document.getElementsByName('phone_number')[0].value;
    let address = document.getElementsByName('address')[0].value;
    let city = document.getElementsByName('city')[0].value;
    let request = new XMLHttpRequest;

    request.open('POST', 'update_customer_infos.php?mode=' + 1);
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.responseText == '200') {

                console.log('succeed');
                cancel();

            } else {

                console.log(request.responseText);

            }
        }
    }
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send("mail=" + mail + "&firstname=" + firstname + "&lastname=" + lastname + "&phone_number=" + phone_number + "&address=" + address + "&city=" + city + "&cid=" + cid);

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

    let section = document.getElementsByClassName('container')[1];
    let old_password = document.getElementsByName('old_password')[0].value;
    let new_password = document.getElementsByName('new_password')[0].value;
    let new_password2 = document.getElementsByName('new_password2')[0].value;
    let request = new XMLHttpRequest;

    request.open('POST', 'update_customer_infos.php?mode=' + 2);
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.responseText == '200') {

                console.log('succeed');
                cancelPasswd();

            } else {

                console.log(request.responseText);

            }
        }
    }
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send("old_password=" + old_password + "&new_password=" + new_password + "&new_password2=" + new_password2 + "&cid=" + cid);


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

function allocate(htmlCid) {

    cid = htmlCid;

}