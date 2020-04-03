function resend(mode) {

    loading();
    let mail = document.getElementsByName('mail')[0].value;
    let request = new XMLHttpRequest;
    let st;

    if (mode == 1)
        st = 'c';
    else
        st = 'a';

    request.open('POST', 'temp_passwd.php?st=' + st);
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.responseText == "200") {

                console.log("success");
                replace();

            } else {

                console.log("error");

                if (mode == 1)
                    self.location.href = "passwd_forgotten.php?status=customer&e=inputs";
                else
                    self.location.href = "passwd_forgotten.php?status=associate&e=inputs";

            }
        }
    }
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send("mail=" + mail);

}

function replace() {

    let section = document.getElementsByClassName('container')[0];

    while (section.firstChild)
        section.removeChild(section.firstChild);

    const img = document.createElement('img');
    img.src = "img/valid_icon.png";
    img.style.width = "300px";
    section.appendChild(img);

    const title = document.createElement('h1');
    title.innerHTML = "Adresse mail vérifiée";
    section.appendChild(title);

    const text = document.createElement('h2');
    text.innerHTML = "Un mail vous a été adressé pour la suite de la procédure";
    section.appendChild(text);

    const a = document.createElement('a');
    a.className = "btn btn-dark";
    a.href = "index.php";
    a.innerHTML = "Revenir à l'accueil";
    a.style.marginTop = "30px";
    section.appendChild(a);

}

function loading() {

    let section = document.getElementsByClassName('container')[0];
    let div = document.createElement('div');
    let br = document.createElement('br');

    section.appendChild(br);

    div.className = "spinner-border";
    section.appendChild(div);

    let span = document.createElement('span');
    span.className = "sr-only";
    div.appendChild(span);

}