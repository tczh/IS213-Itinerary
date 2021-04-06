#!/usr/bin/env python3
# The above shebang (#!) operator tells Unix-like environments
# to run this file as a python3 script
import json
import os, sys

# Import Settings from RabbitMQ
import rabbitMQSetup

import imageCompose
import gmailCompose

def receiveMessages():
	rabbitMQSetup.check_setup()

	# Notification microservice consumes messages for 2 queues, Approval and Payment
	rabbitMQSetup.channel.basic_consume(queue="Approval", on_message_callback=approvalCallback, auto_ack=True)
	rabbitMQSetup.channel.basic_consume(queue="Payment", on_message_callback=paymentCallback, auto_ack=True)
	rabbitMQSetup.channel.start_consuming() # an implicit loop waiting to receive messages; 
	#it doesn't exit by default. Use Ctrl+C in the command window to terminate it.

def approvalCallback(channel, method, properties, body): # required signature for the callback; no return
	print("\nReceived an Itinerary Approval Request from " + __file__)
	sendNotification(body, "Approval")

def paymentCallback(channel, method, properties, body): # required signature for the callback; no return
	print("\nReceived an Itinerary Payment Request from " + __file__)
	sendNotification(body, "Payment")

def sendNotification(body, statusType):
	# body is always encoded, therefore decode it to string format
	message = body.decode().split(",")
	email = message[0]
	itineraryid = message[1]
	customerName = email.split("@")[0]

	# Create IMG with Customer Details
	print("Creating IMG with item details...")
	if (statusType == "Approval"):
		createdIMG = imageCompose.createApproval(customerName, itineraryid)
	else:
		createdIMG = imageCompose.createPayment(customerName)
	print("IMG Creation Completed")

	# Craft and Send Email
	print("Sending Email to " + email + "...")
	if (statusType == "Approval"):
		gmailCompose.sendEmail(email, itineraryid, createdIMG, "Approval")
	else:
		gmailCompose.sendEmail(email, itineraryid, createdIMG, "Payment")
	print("Email Sent Successfully")

	print() # print a new line feed

if __name__ == "__main__":  # execute this program only if it is run as a script (not by 'import')
	print("\nThis is " + os.path.basename(__file__), end='')
	print(": monitoring routing key 'Approval' and 'Payment' in exchange '{}' ...".format(rabbitMQSetup.exchangename))
	receiveMessages()