from flask import Flask, request, jsonify
from flask_cors import CORS

import os, sys

import requests

import rabbitMQSetup
import pika
import json

app = Flask(__name__)
CORS(app)

### THIS SECTION IS TO BE DELETED, FOR TESTING PURPOSES ONLY. ###
@app.route("/purchase_itinerary", methods=['POST'])
def test ():
	#ARG[0]: Customer to Send Email to; 
	#ARG[1]: Customer Name
	#ARG[2]: Payment ID
	send_itinerary_payment("elgin.rspx@gmail.com", "Elgin Payment", "ID321A") 
	return {
        "code": 201,
        "status": "Success"
    }
### END SECTION ###

# Call this function to send a Fire-and-Forget itinerary purchase status notification (email) to User 
def send_itinerary_payment(email, customerName, itemID):
	print("\nSending Itinerary Payment Notification to:", email)

	message = email + "," + customerName + "," + itemID

	# Send Itinerary Payment Request for Processing, Set Messages to be Persistent
	rabbitMQSetup.channel.basic_publish(exchange=rabbitMQSetup.exchangename, routing_key="itinerary.payment", body=message, properties=pika.BasicProperties(delivery_mode = 2)) 
	
# Execute this program if it is run as a main script (not by 'import')
if __name__ == "__main__":
    print("This is flask " + os.path.basename(__file__) + " for Purchase Itinerary")
    app.run(host="0.0.0.0", port=5300, debug=True)
    # Notes for the parameters: 
    # - debug=True will reload the program automatically if a change is detected;
    #   -- it in fact starts two instances of the same flask program, and uses one of the instances to monitor the program changes;
    # - host="0.0.0.0" allows the flask program to accept requests sent from any IP/host (in addition to localhost),
    #   -- i.e., it gives permissions to hosts with any IP to access the flask program,
    #   -- as long as the hosts can already reach the machine running the flask program along the network;
    #   -- it doesn't mean to use http://0.0.0.0 to access the flask program.