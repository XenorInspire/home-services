function subscribe(){

    // Set your publishable key: remember to change this to your live publishable key in production
    // See your keys here: https://dashboard.stripe.com/account/apikeys
    var stripe = Stripe('pk_test_Gz8JFeemGgLj6Bfuld5OnOix00e3XMnZ1x');
    var elements = stripe.elements();
    var cardElement = elements.create('card');
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
                console.log('error');
            } else {

                console.log('succeed');
            }
        });
    });

}