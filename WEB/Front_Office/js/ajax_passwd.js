function resend(mode) {

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