function check_mail_registration() {

    let description = document.getElementById('emailHelp');
    let mail = document.getElementsByName('mail')[0].value;
    let button = document.getElementById('regis_button');
    let request = new XMLHttpRequest;

    request.open('POST', 'check_mail.php');
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.responseText == "1") {
                description.style.display = "block";
                description.innerHTML = "Cette adresse mail existe déjà !";
                description.style.color = "red";
                button.disabled = true;
            } else {

                description.innerHTML = "Votre adresse mail ne sera pas partagée.";
                description.style.color = "#6c757d";
                button.disabled = false;

            }
        }
    }
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send("mail=" + mail);
}

function check_mail_connection() {

    let description = document.getElementById('emailHelp');
    let mail = document.getElementsByName('mail')[0].value;
    let button = document.getElementById('regis_button');
    let request = new XMLHttpRequest;

    request.open('POST', 'check_mail.php');
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.responseText == "1") {

                description.style.display = "none";
                button.disabled = false;

            } else {

                description.style.display = "block";
                button.disabled = true;

            }
        }
    }
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send("mail=" + mail);
}