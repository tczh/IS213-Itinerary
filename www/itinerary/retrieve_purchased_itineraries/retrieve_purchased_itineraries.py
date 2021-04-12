from flask import Flask, request, jsonify
from flask_cors import CORS

import os
from os import environ

import requests
from invokes import invoke_http

app = Flask(__name__)
CORS(app)

payment_URL = environ.get('payment_URL') or "http://localhost:5016/payment/user/"
itinerary_URL = environ.get('itinerary_URL') or "http://localhost:5010/itinerary/" 

@app.route("/retrieve_purchased_itineraries", methods=['POST'])
def retrieve_purchased_itineraries():
    # Simple check of input format and data of the request are JSON
    if request.is_json:
        try:
            emailaddr = request.get_json()
            print("\nReceived an order in JSON:", emailaddr)
            # do the actual work
            # 1. Send itinerary info {itineraryid}
            result = processRetrievePurchasedItineraries(emailaddr)
            return jsonify(result), result["code"]

        except Exception as e:
            pass  # do nothing.
    # if reached here, not a JSON request.
    return jsonify({
        "code": 400,
        "message": "Invalid JSON input: " + str(request.get_data())
    }), 400

def processRetrievePurchasedItineraries(emailaddr):
    # Invoke the payment microservice
    print('\n-----Invoking payment microservice-----')
    searchid = str(emailaddr['emailaddr'])
    payment_info = invoke_http(payment_URL + searchid, method='GET')
    print('payment:', payment_info)
    itineraryidarray =[]
    payment_info = payment_info["data"]["payment"]
    for payment in payment_info:
        if(payment['isPaid'].lower() == "true"):
            for paymentitem in payment['paymentItems']:
                if(paymentitem['itineraryID'] not in itineraryidarray):
                    itineraryidarray.append(paymentitem['itineraryID'])
                    
    
    print('\n-----Invoking itinerary microservice-----')
    purchasearray=[]
    for itineraryid in itineraryidarray:
        itinerary_info = invoke_http(itinerary_URL + str(itineraryid), method='GET')
        print('itinerary_info:', itinerary_info["data"])
        purchasearray.append(itinerary_info["data"])
    return {
        "code": 201,
        "data": {
            "itinerary_info": purchasearray
        }
    }    

if __name__ == "__main__":
    print("This is flask " + os.path.basename(__file__) +
          " for displaying itinerary...")
    app.run(host="0.0.0.0", port=5400, debug=True)