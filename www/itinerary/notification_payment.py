#!/usr/bin/env python3
# The above shebang (#!) operator tells Unix-like environments
# to run this file as a python3 script
import json
import os, sys

# Import Settings from RabbitMQ
import rabbitMQSetup

import os.path
from googleapiclient.discovery import build
from google_auth_oauthlib.flow import InstalledAppFlow
from google.auth.transport.requests import Request
from google.oauth2.credentials import Credentials

import base64
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

monitorBindingKey='itinerary.payment'

def receivePayment():
	rabbitMQSetup.check_setup()

	queue_name = "Payment"

	# set up a consumer and start to wait for coming messages
	rabbitMQSetup.channel.basic_consume(queue=queue_name, on_message_callback=callback, auto_ack=True)
	rabbitMQSetup.channel.start_consuming() # an implicit loop waiting to receive messages; 
	#it doesn't exit by default. Use Ctrl+C in the command window to terminate it.

def callback(channel, method, properties, body): # required signature for the callback; no return
	print("\nReceived an Itinerary Payment Request from " + __file__)

	# body is always encoded, therefore decode it back to string format before sending email
	email = body.decode()
	sendEmail(email)
	print() # print a new line feed

SCOPES = ['https://www.googleapis.com/auth/gmail.compose']

def sendEmail(customer_email):
	"""Shows basic usage of the Gmail API.
	Lists the user's Gmail labels.
	"""
	creds = None
	# The file token.json stores the user's access and refresh tokens, and is
	# created automatically when the authorization flow completes for the first
	# time.
	if os.path.exists('token.json'):
		creds = Credentials.from_authorized_user_file('token.json', SCOPES)
	# If there are no (valid) credentials available, let the user log in.
	if not creds or not creds.valid:
		if creds and creds.expired and creds.refresh_token:
			creds.refresh(Request())
		else:
			flow = InstalledAppFlow.from_client_secrets_file(
				'credentials.json', SCOPES)
			creds = flow.run_local_server(port=0)
		# Save the credentials for the next run
		with open('token.json', 'w') as token:
			token.write(creds.to_json())

	service = build('gmail', 'v1', credentials=creds)

	# Build content of email
	emailMsg = 'This email is to notify you that your Itinerary Payment is successful.'
	mimeMessage = MIMEMultipart()
	mimeMessage['to'] = customer_email
	mimeMessage['subject'] = 'IS213 Itinerary - Itinerary Payment Status'
	mimeMessage.attach(MIMEText(emailMsg, 'plain'))
	raw_string = base64.urlsafe_b64encode(mimeMessage.as_bytes()).decode()

	# Sent built content
	message = service.users().messages().send(userId='me', body={'raw': raw_string}).execute()

if __name__ == "__main__":  # execute this program only if it is run as a script (not by 'import')
	print("\nThis is " + os.path.basename(__file__), end='')
	print(": monitoring routing key '{}' in exchange '{}' ...".format(monitorBindingKey, rabbitMQSetup.exchangename))
	receivePayment()