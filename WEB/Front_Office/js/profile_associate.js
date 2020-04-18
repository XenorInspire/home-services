var aid;

function enable() {

    let section = document.getElementsByClassName('container')[0];
    let button = section.getElementsByClassName('btn')[0];
    let newButton = document.createElement('button');
    let inputs = section.getElementsByTagName('input');
    let infos = document.getElementById('infos');

    button.innerHTML = "Valider";
    button.onclick = validate;

    infos.style.display = "none";

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
    let div = document.createElement('div');
    let span = document.createElement('span');
    let firstname = document.getElementsByName('firstname')[0].value;
    let lastname = document.getElementsByName('lastname')[0].value;
    let mail = document.getElementsByName('mail')[0].value;
    let phone_number = document.getElementsByName('phone_number')[0].value;
    let address = document.getElementsByName('address')[0].value;
    let city = document.getElementsByName('city')[0].value;

    for (let i = 0; i < 2; i++) {

        let br = document.createElement('br');
        br.className = "br";
        section.appendChild(br);

    }

    div.className = "spinner-border";
    div.id = "spinner";
    section.appendChild(div);

    span.className = "sr-only";
    div.appendChild(span);

    let request = new XMLHttpRequest;

    request.open('POST', 'update_associate_infos.php?mode=' + 1);
    request.onreadystatechange = function () {
        if (request.readyState === 4) {

            var infos = document.getElementById('infos');

            if (request.responseText == '200') {

                console.log('succeed');
                infos.style.display = "block";
                infos.innerHTML = "Vos modifications ont été enregistrées !";
                infos.style.color = "green";
                cancel();

            } else {

                infos.style.display = "block";
                infos.innerHTML = "Une ou plusieurs modifications sont invalides.";
                infos.style.color = "red";
                cancel();

            }
        }
    }
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send("mail=" + mail + "&firstname=" + firstname + "&lastname=" + lastname + "&phone_number=" + phone_number + "&address=" + address + "&city=" + city + "&aid=" + aid);

}

function cancel() {

    let section = document.getElementsByClassName('container')[0];
    let inputs = section.getElementsByTagName('input');
    let button = section.getElementsByClassName('btn')[0];
    let oldButton = section.getElementsByClassName('btn')[1];
    let div = document.getElementById('spinner');
    let br = section.getElementsByClassName('br');

    for (let i = 0; i < br.length; i++)
        br[i].remove();

    if (div != null)
        div.remove();

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
    let infos = document.getElementById('infos_passwd');

    button.innerHTML = "Valider";
    button.onclick = validatePasswd;

    infos.style.display = "none";

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

    let old_password = document.getElementsByName('old_password')[0].value;
    let new_password = document.getElementsByName('new_password')[0].value;
    let new_password2 = document.getElementsByName('new_password2')[0].value;
    let section = document.getElementsByClassName('container')[1];
    let div = document.createElement('div');
    let span = document.createElement('span');

    for (let i = 0; i < 2; i++) {

        let br = document.createElement('br');
        br.className = "br";
        section.appendChild(br);

    }

    div.className = "spinner-border";
    div.id = "spinner";
    section.appendChild(div);

    span.className = "sr-only";
    div.appendChild(span);

    let request = new XMLHttpRequest;

    request.open('POST', 'update_associate_infos.php?mode=' + 2);
    request.onreadystatechange = function () {
        if (request.readyState === 4) {

            var infos = document.getElementById('infos_passwd');

            if (request.responseText == '200') {

                console.log('succeed');
                infos.style.display = "block";
                infos.innerHTML = "Votre mot de passe a bien été changé !";
                infos.style.color = "green";
                cancelPasswd();

            } else {

                infos.style.display = "block";
                infos.innerHTML = "Mot de passe invalide";
                infos.style.color = "red";
                cancelPasswd();

            }
        }
    }
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send("old_password=" + old_password + "&new_password=" + new_password + "&new_password2=" + new_password2 + "&aid=" + aid);


}

function cancelPasswd() {

    let section = document.getElementsByClassName('container')[1];
    let inputs = section.getElementsByTagName('input');
    let button = section.getElementsByClassName('btn')[0];
    let oldButton = section.getElementsByClassName('btn')[1];
    let div = document.getElementById('spinner');
    let br = section.getElementsByClassName('br');

    for (let i = 0; i < br.length; i++)
        br[i].remove();

    if (div != null)
        div.remove();

    button.innerHTML = "Modifier mes informations";
    button.onclick = enablePasswd;

    for (let i = 0; i < inputs.length; i++) {

        inputs[i].style.border = "1px solid #ced4da";
        inputs[i].style.boxShadow = "";
        inputs[i].disabled = true;

    }

    section.removeChild(oldButton);

}

function allocate(htmlAid) {

    aid = htmlAid;

}