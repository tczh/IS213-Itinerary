from flask import Flask, request, jsonify
from flask_cors import CORS
from invokes import invoke_http

import os, sys
from os import environ

import requests

import rabbitMQSetup
import pika
import json

app = Flask(__name__)
CORS(app)

itineraryapprove_URL = environ.get('itineraryapprove_URL') or "http://localhost:5010/approveitinerary/"

@app.route("/itinerary_approval", methods=['POST'])
def approve_itinerary():
    if request.is_json:
        try:
            itineraryid = request.get_json()
            print("\nReceived an order in JSON:", itineraryid)
            # do the actual work
            # 1. Send itinerary info {itineraryid}
            result = processUpdateItinerary(itineraryid)
            send_itinerary_approval(result["data"]["itinerarycreator"], "ID" + str(itineraryid["itineraryid"]))
            return {
                "code": 201,
                "status": "Success"
            }
            # return jsonify(result), result["code"]
        except Exception as e:
            pass  # do nothing.
    # if reached here, not a JSON request.
    return jsonify({
        "code": 400,
        "message": "Invalid JSON input: " + str(request.get_data())
    }), 400

# Call this function to send a Fire-and-Forget itinerary approval status notification (email) to User 
def send_itinerary_approval(email, itineraryid):
	print("\nSending Itinerary Approval Notification to:", email)
	message = email + "," + itineraryid
	
	# Send Itinerary Approval Request for Processing, Set Messages to be Persistent
	rabbitMQSetup.channel.basic_publish(exchange=rabbitMQSetup.exchangename, routing_key="itinerary.approval", body=message, properties=pika.BasicProperties(delivery_mode = 2)) 
	
def processUpdateItinerary(itineraryid):
    print('\n-----Invoking itinerary microservice-----')
    searchid = str(itineraryid['itineraryid'])
    itinerary_info = invoke_http(itineraryapprove_URL + searchid, method='PUT')
    return {
        "code": 201,
        "data": {
            "itinerarycreator": itinerary_info['data']['itinerarycreator']
        }
    }

# Execute this program if it is run as a main script (not by 'import')
if __name__ == "__main__":
    print("This is flask " + os.path.basename(__file__) + " for Itinerary Approval")
    app.run(host="0.0.0.0", port=5100, debug=True)
    # Notes for the parameters: 
    # - debug=True will reload the program automatically if a change is detected;
    #   -- it in fact starts two instances of the same flask program, and uses one of the instances to monitor the program changes;
    # - host="0.0.0.0" allows the flask program to accept requests sent from any IP/host (in addition to localhost),
    #   -- i.e., it gives permissions to hosts with any IP to access the flask program,
    #   -- as long as the hosts can already reach the machine running the flask program along the network;
    #   -- it doesn't mean to use http://0.0.0.0 to access the flask program.