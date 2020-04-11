function getList() {

    let select = document.getElementById('sel').value;
    let main = document.getElementsByTagName('main')[0];
    let request = new XMLHttpRequest;

    request.open('POST', 'get_services_list.php');
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.responseText != "400") {

                let section = document.getElementsByClassName('container')[1];
                section.innerHTML = request.responseText;

            } else {

                console.log('error');

            }
        }
    }
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send("select=" + select);

}