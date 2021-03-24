#!/usr/bin/env python3
# The above shebang (#!) operator tells Unix-like environments
# to run this file as a python3 script
import json
import os, sys

# Import Settings from RabbitMQ
import rabbitMQSetup

import imgCompose
import gmailCompose

monitorBindingKey='itinerary.approval'

def receiveApproval():
	rabbitMQSetup.check_setup()

	queue_name = "Approval"

	# set up a consumer and start to wait for coming messages
	rabbitMQSetup.channel.basic_consume(queue=queue_name, on_message_callback=callback, auto_ack=True)
	rabbitMQSetup.channel.start_consuming() # an implicit loop waiting to receive messages; 
	#it doesn't exit by default. Use Ctrl+C in the command window to terminate it.

def callback(channel, method, properties, body): # required signature for the callback; no return
	print("\nReceived an Itinerary Approval Request from " + __file__)

	# body is always encoded, therefore decode it back to string format before sending email
	message = body.decode().split(",")
	email = message[0]
	customerName = message[1]
	itemID = message[2]

	# Create PDF with Customer Details
	print("Creating IMG with item details...")
	createdIMG = imgCompose.createIMG(customerName, itemID, "Approval")
	print("IMG Creation Completed")
	print("Sending Email to " + email + "...")
	gmailCompose.sendEmail(email, itemID, createdIMG, "Approval")
	print("Email Sent Successfully")
	print() # print a new line feed

if __name__ == "__main__":  # execute this program only if it is run as a script (not by 'import')
	print("\nThis is " + os.path.basename(__file__), end='')
	print(": monitoring routing key '{}' in exchange '{}' ...".format(monitorBindingKey, rabbitMQSetup.exchangename))
	receiveApproval()