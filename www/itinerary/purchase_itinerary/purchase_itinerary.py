from flask import Flask, request, jsonify
from flask_cors import CORS

import os, sys
from os import environ

import requests
from invokes import invoke_http

import rabbitMQSetup
import pika
import json
import imageCompose
import gmailCompose

app = Flask(__name__)
CORS(app)

cart_URL = environ.get('cart_URL') or "http://localhost:5015/cart"
payment_URL = environ.get('payment_URL') or "http://localhost:5016/payment"
paymentIntent_URL = environ.get('paymentIntent_URL') or "http://localhost:5016/createPaymentIntent"

@app.route("/purchase_itinerary", methods=['POST'])
def purchase_itinerary():
    # Simple check of input format and data of the request are JSON
    if request.is_json:
        try:
            cart_info = request.get_json()
            print("\nReceived cart information!")

            # do the actual work
            # 1. Send cart info 
            result = processPurchaseItinerary(cart_info)
            return jsonify(result), result["code"]

        except Exception as e:
            # Unexpected error in code
            exc_type, exc_obj, exc_tb = sys.exc_info()
            fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
            ex_str = str(e) + " at " + str(exc_type) + ": " + fname + ": line " + str(exc_tb.tb_lineno)
            print(ex_str)

            return jsonify({
                "code": 500,
                "message": "purchase_itinerary.py internal error: " + ex_str
            }), 500

    # if reached here, not a JSON request.
    return jsonify({
        "code": 400,
        "message": "Invalid JSON input: " + str(request.get_data())
    }), 400


def processPurchaseItinerary(cart_info):
    # 2. Retrieve all the cart items
    # Invoke cart microservice
    cartID = cart_info['cartID']

    print('\n-----Invoking cart microservice-----')
    cart_result = invoke_http(cart_URL + '/' + str(cartID))
    print('cart_result:', cart_result)

    # 3. Create new payment record
    # Invoke payment microservice
    print(cart_info)
    combine_json_data = cart_result['data']
    combine_json_data['cartID'] = cartID
    combine_json_data['emailAddr'] = cart_info['emailAddr']
    combine_json_data['totalPrice'] = cart_info['totalPrice']

    print('\n-----Invoking payment microservice-----')
    payment_result = invoke_http(payment_URL, method="POST", json=combine_json_data)
    print('payment_result:', payment_result)

    # 4. Return cart and payment results
    return {
        "code": 201,
        "data": {
            "cart_items": cart_result['data'],
            "payment_result": payment_result
        }
    }

@app.route("/purchase_itinerary/purchase", methods=['POST'])
def createPaymentIntent():
    # Simple check of input format and data of the request are JSON
    if request.is_json:
        try:
            payment_info = request.get_json()
            print("\nReceived payment information!")

            # 1. Create paymentintent 
            # Invoke payment microservice
            print('\n-----Invoking payment microservice-----')
            paymentIntent_result = invoke_http(paymentIntent_URL, method="POST", json=payment_info)
            print('payment_result:', paymentIntent_result)

            # 4. Return paymentIntent result
            return {
                "code": 201,
                "paymentIntent": paymentIntent_result 
            }

        except Exception as e:
            # Unexpected error in code
            exc_type, exc_obj, exc_tb = sys.exc_info()
            fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
            ex_str = str(e) + " at " + str(exc_type) + ": " + fname + ": line " + str(exc_tb.tb_lineno)
            print(ex_str)

            return jsonify({
                "code": 500,
                "message": "purchase_itinerary.py internal error: " + ex_str
            }), 500

    # if reached here, not a JSON request.
    return jsonify({
        "code": 400,
        "message": "Invalid JSON input: " + str(request.get_data())
    }), 400
    
@app.route("/purchase_itinerary/update", methods=['POST'])
def update_payment():
    if request.is_json:
        try:
            payment_info = request.get_json()
            print("\nReceived payment information for update!")

            # 1. Update database for payment made 
            # Invoke payment microservice
            print('\n-----Invoking payment microservice-----')
            payment_update_result = invoke_http(payment_URL, method="PUT", json=payment_info)
            print('payment_update_result:', payment_update_result)

            paymentDate = payment_update_result["data"]["dateBought"][5:16]
            if (payment_update_result['code'] == 200):
                createdIMG = imageCompose.createReceipt(payment_info["billingName"], str( "{:.2f}".format(payment_update_result["data"]["totalPrice"]) ), paymentDate)
                print("IMG Creation Completed")
            
                # Craft and Send Email
                print("Sending Email to " + payment_info["billingEmail"] + "...")
                gmailCompose.sendEmail(payment_info["billingEmail"], "null", createdIMG, "Receipt")	
                print("Email Sent Successfully")
				
                print("\nSending Itinerary Payment Notification to:", payment_info["emailAddr"])
                message = payment_info["emailAddr"] + "," + payment_info["fullName"] + "," + "null"
 
                # Send Itinerary Payment Request for Processing, Set Messages to be Persistent
                rabbitMQSetup.channel.basic_publish(exchange=rabbitMQSetup.exchangename, routing_key="itinerary.payment", body=message, properties=pika.BasicProperties(delivery_mode = 2)) 
                
                print('\n-----Invoking cart microservice-----')
                cart_result = invoke_http(cart_URL, method="DELETE", json=payment_info)
                print('Deletion Result:', cart_result)

                if (cart_result["code"] == 200):
                    return {
                        "code": 201,
                        "status": "Success!"
                    }
            else:
                return paymentIntent_update_result

        except Exception as e:
            # Unexpected error in code
            exc_type, exc_obj, exc_tb = sys.exc_info()
            fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
            ex_str = str(e) + " at " + str(exc_type) + ": " + fname + ": line " + str(exc_tb.tb_lineno)
            print(ex_str)

            return jsonify({
                "code": 500,
                "message": "purchase_itinerary.py internal error: " + ex_str
            }), 500

    # if reached here, not a JSON request.
    return jsonify({
        "code": 400,
        "message": "Invalid JSON input: " + str(request.get_data())
    }), 400
 
# Execute this program if it is run as a main script (not by 'import')
if __name__ == "__main__":
    print("This is flask " + os.path.basename(__file__) + " for purchasing itinerary")
    app.run(host="0.0.0.0", port=5300, debug=True)
    # Notes for the parameters:
    # - debug=True will reload the program automatically if a change is detected;
    #   -- it in fact starts two instances of the same flask program,
    #       and uses one of the instances to monitor the program changes;
    # - host="0.0.0.0" allows the flask program to accept requests sent from any IP/host (in addition to localhost),
    #   -- i.e., it gives permissions to hosts with any IP to access the flask program,
    #   -- as long as the hosts can already reach the machine running the flask program along the network;
    #   -- it doesn't mean to use http://0.0.0.0 to access the flask program.
