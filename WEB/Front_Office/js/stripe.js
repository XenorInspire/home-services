var sid;
var cid;
var sp;

function load_stripe(mode) {

    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    var stripe = Stripe('pk_test_Gz8JFeemGgLj6Bfuld5OnOix00e3XMnZ1x');
    var elements = stripe.elements();
    var cardElement = elements.create('card', { style: style });
    cardElement.mount('#card-element');
    var cardholderName = document.getElementById('cardholder-name');

    var cardButton = document.getElementById('card-button');
    var clientSecret = cardButton.dataset.secret;

    cardButton.addEventListener('click', function (ev) {
        stripe.handleCardPayment(
            clientSecret, cardElement, {
            payment_method_data: {
                billing_details: {
                    name: cardholderName.value
                }
            }
        }
        ).then(function (result) {
            if (result.error) {

                tryAgain();
                console.log('error');

            } else {

                if (mode == 1) {

                    insert();
                    replace();

                } else {

                    update();
                    serviceBooked();
                }

            }
        });
    });

}

function replace() {

    let section = document.getElementById("subscription_block");

    while (section.firstChild)
        section.removeChild(section.firstChild);

    const img = document.createElement('img');
    img.src = "img/valid_icon.png";
    img.style.width = "300px";
    section.appendChild(img);

    const title = document.createElement('h1');
    title.innerHTML = "Paiement accepté";
    section.appendChild(title);

    const text = document.createElement('h2');
    text.innerHTML = "Vous êtes désormais abonné !";
    section.appendChild(text);

    const a = document.createElement('a');
    a.className = "btn btn-dark";
    a.href = "shop.php";
    a.innerHTML = "Revenir à la boutique";
    a.style.marginTop = "30px";
    section.appendChild(a);

}

function loading() {

    let msg = document.getElementById('payInfos');
    msg.style.display = "none";

    let section = document.getElementById("subscription_block");
    let div = document.createElement('div');

    div.className = "spinner-border";
    section.appendChild(div);

    let span = document.createElement('span');
    span.className = "sr-only";
    div.appendChild(span);

}

function allocate(htmlCid, htmlSid) {

    sid = htmlSid;
    cid = htmlCid;

}

function insert() {

    let request = new XMLHttpRequest;

    request.open('GET', 'customer_payment.php?cid=' + cid + '&sid=' + sid);
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.responseText != "200") {

                self.location.href = "shop.php?err=inp";

            }
        }
    }
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send();

}

function tryAgain() {

    let div = document.getElementsByClassName('spinner-border')[0];
    let msg = document.getElementById('payInfos');

    div.remove();
    msg.style.display = "block";

}

function serviceBooked() {

    let section = document.getElementById("subscription_block");

    while (section.firstChild)
        section.removeChild(section.firstChild);

    const img = document.createElement('img');
    img.src = "img/valid_icon.png";
    img.style.width = "300px";
    section.appendChild(img);

    const title = document.createElement('h1');
    title.innerHTML = "Paiement accepté";
    section.appendChild(title);

    const text = document.createElement('h2');
    text.innerHTML = "La prestation a bien été payée.";
    section.appendChild(text);

    const a = document.createElement('a');
    a.className = "btn btn-dark";
    a.href = "orders.php";
    a.innerHTML = "Revenir sur mes commandes";
    a.style.marginTop = "30px";
    section.appendChild(a);

}

function update() {

    let request = new XMLHttpRequest;

    request.open('GET', 'update_service.php?cid=' + cid + '&sp=' + sp);
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.responseText != "200") {

                self.location.href = "orders.php?error=inp";

            }
        }
    }
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send();

}

function sp(htmlCid, htmlSp) {

    sp = htmlSp;
    cid = htmlCid;

}