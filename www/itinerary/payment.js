// A reference to Stripe.js
function retrieveLoad(){
    
    var apiKey = 'pk_test_51IY8rSKA7uVreypXmCCcFfkC5jLtkNmHOqi1pqBhLVET7XuOCaeA1P4H1sehvk28D5J7XrHoXclkp8k5ZOUz9gBT00lcZUHboS';
    var stripe;

    var cartData = {
        totalPrice: sessionStorage.getItem("totalPrice"),
        key: apiKey,
        currency: "sgd"
    };
    var results = sessionStorage.getItem("quantity");
    document.getElementById("quantity").innerText = results;
    document.getElementById("price").innerText = sessionStorage.getItem("totalPrice");
    var serviceURL = "http://localhost:5300/purchase_itinerary/purchase";

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var result = JSON.parse(this.responseText);
            var paymentObject = setupElements(result.paymentIntent);
            sessionStorage.setItem("paymentObject", paymentObject);
            // Handle form submission.
            var form = document.getElementById("submit");
            form.addEventListener("click", function(event) {
                event.preventDefault();
                var inputValue = document.getElementById("email").value;
                if (inputValue.includes("@")) {
                    event.preventDefault();
                    // Initiate payment when the submit button is clicked
                    pay(paymentObject["stripe"], paymentObject["card"], paymentObject["clientSecret"]); 
                } else {
                    document.getElementById("modalHeader").innerText = "Invalid Email!";
                    document.getElementById("modalBody").innerText = "Please ensure you have entered a valid email.";
                    document.getElementById("modalBtn").innerText = "Close";
                    document.getElementById("modalBtn").addEventListener("click", function(event){
                        $('#paymentModal').modal('hide');
                        });
                        $('#paymentModal').modal('show');
                    }      
            });   
        }
    }
    request.open("POST", serviceURL, false);
    request.setRequestHeader("Content-type", "application/json");
    request.send(JSON.stringify(cartData));
}

function updateDatabase() {          
    paymentURL = "http://localhost:5300/purchase_itinerary/update";
    var billingEmail = document.getElementById("email").value;
    var billingName = document.getElementById("name").value;
    var splitArr = sessionStorage.getItem("emails").split("@");
    var secondData = {
        cartID: sessionStorage.getItem("cartId"),
        paymentID: sessionStorage.getItem("paymentId"),
        emailAddr: sessionStorage.getItem("emails"),
        fullName: splitArr[0],
        billingEmail: billingEmail,
        billingName: billingName
    };

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);

            if (data["code"] == "201") {
                document.getElementById("modalHeader").innerText = "Payment Success!";
                document.getElementById("modalBody").innerText = "Your payment receipt and payment confirmation has been sent to your email.";
                document.getElementById("modalBtn").innerText = "Back to Home";
                document.getElementById("modalBtn").setAttribute("href", "index.php")
                $('#paymentModal').modal('show');
            }
        }
    }
    request.open("POST", paymentURL, true);
    request.setRequestHeader("Content-type", "application/json");
    request.send(JSON.stringify(secondData));
}

var setupElements = function(data) {
    stripe = Stripe(data.publishableKey);
    /* ------- Set up Stripe Elements to use in checkout form ------- */
    var elements = stripe.elements();
    var style = {
        base: {
            color: "#32325d",
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: "antialiased",
            fontSize: "16px",
            "::placeholder": {
              color: "#aab7c4"
            }
        },
        invalid: {
            color: "#fa755a",
            iconColor: "#fa755a"
        }
    };

    var card = elements.create("card", {style: style, hidePostalCode: true});
    card.mount("#card-element");

    return {
        stripe: stripe,
        card: card,
        clientSecret: data.clientSecret
    };
};

function pay (stripe, card, clientSecret) {
    // Initiate the payment.
    // If authentication is required, confirmCardPayment will automatically display a modal
    var results = stripe.confirmCardPayment(clientSecret, {
            payment_method: {
                card: card
            }
        })
    results.then(function(result) {
        if (result.error) {
            // Show error to your customer
            displayError();
        } else {
            // The payment has been processed!
            updateDatabase();
        }

    });
};

function displayError() {
    document.getElementById("modalHeader").innerText = "Invalid Card!";
    document.getElementById("modalBody").innerText = "Please ensure you have entered a valid card.";
    document.getElementById("modalBtn").innerText = "Close";
    document.getElementById("modalBtn").addEventListener("click", function(event){
        $('#paymentModal').modal('hide');
    });
    $('#paymentModal').modal('show');
}
