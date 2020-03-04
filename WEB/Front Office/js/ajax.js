function check_mail() {

    let description = document.getElementById('emailHelp');
    let mail = document.getElementsByName('mail')[0].value;
    let request = new XMLHttpRequest;

    request.open('POST', 'check_mail.php');
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.responseText == "1") {
                description.innerHTML = "Cette adresse mail existe déjà !";
                description.style.color = "red";
                console.log('déjà prise');
            } else {
                description.innerHTML = "Votre adresse mail ne sera pas partagée.";
                description.style.color = "#6c757d";
                console.log('pas prise');
            }
        }
    }
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send("mail=" + mail);
}
