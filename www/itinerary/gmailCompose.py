# Google Settings
import os.path
from googleapiclient.discovery import build
from google_auth_oauthlib.flow import InstalledAppFlow
from google.auth.transport.requests import Request
from google.oauth2.credentials import Credentials

# Create Email Settings
import base64
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from email.mime.audio import MIMEAudio
from email.mime.image import MIMEImage
from email.mime.base import MIMEBase
import mimetypes

SCOPES = ['https://www.googleapis.com/auth/gmail.compose']

def sendEmail(customer_email, itineraryid, imgName, statusType):
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
	if (statusType == "Approval"):
		emailMsg = 'This email is to notify you that your itinerary has been approved!'
		mimeMessage = MIMEMultipart()
		mimeMessage['to'] = customer_email
		mimeMessage['subject'] = itineraryid + ' - Itinerary Approval Status'
		msg = MIMEText(emailMsg)
		mimeMessage.attach(msg)
	elif (statusType == "Payment"):
		emailMsg = 'This email is to notify you that your itinerary payment is successful!'
		mimeMessage = MIMEMultipart()
		mimeMessage['to'] = customer_email
		mimeMessage['subject'] = 'Itinerary Payment Status'
		msg = MIMEText(emailMsg)
		mimeMessage.attach(msg)
	else: 
		emailMsg = 'This email contains an attached file of your payment receipt!'
		mimeMessage = MIMEMultipart()
		mimeMessage['to'] = customer_email
		mimeMessage['subject'] = 'Payment Receipt'
		msg = MIMEText(emailMsg)
		mimeMessage.attach(msg)

	content_type, encoding = mimetypes.guess_type(imgName)

	if content_type is None or encoding is not None:
		content_type = 'application/octet-stream'
	main_type, sub_type = content_type.split('/', 1)
	if main_type == 'text':
		fp = open(imgName, 'rb')
		msg = MIMEText(fp.read(), _subtype=sub_type)
		fp.close()
	elif main_type == 'image':
		fp = open(imgName, 'rb')
		msg = MIMEImage(fp.read(), _subtype=sub_type)
		fp.close()
	elif main_type == 'audio':
		fp = open(imgName, 'rb')
		msg = MIMEAudio(fp.read(), _subtype=sub_type)
		fp.close()
	else:
		fp = open(imgName, 'rb')
		msg = MIMEBase(main_type, sub_type)
		msg.set_payload(fp.read())
		fp.close()

	filename = os.path.basename(imgName)
	msg.add_header('Content-Disposition', 'attachment', filename=filename)
	mimeMessage.attach(msg)

	raw_string = base64.urlsafe_b64encode(mimeMessage.as_bytes()).decode()

	# Sent built content
	message = service.users().messages().send(userId='me', body={'raw': raw_string}).execute()