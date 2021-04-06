from PIL import Image
from PIL import ImageFont
from PIL import ImageDraw

def createApproval(customerName, itineraryid):
	img = Image.open("approvalTemplate.jpg")
	draw = ImageDraw.Draw(img)

	font = ImageFont.truetype("Helvetica.ttf", 36)
	# draw.text((x, y),"Sample Text",(r,g,b))
	# x, y is the top-left coordinate
	draw.text((200, 560), customerName,(0,0,0), font=font)
	draw.text((750, 560), itineraryid,(0,0,0), font=font)

	draw.text((200, 750), 'This email is to notify you that your itinerary has been',(0,0,0), font=font)
	draw.text((200, 800), 'approved!',(0,0,0), font=font)
	draw.text((200, 900), 'We hope you have a great day ahead!',(0,0,0), font=font)

	filename = "Approval.jpg"
	img.save(filename)
	return filename

def createReceipt(customerName, amountPaid, datePaid):
	img = Image.open("receiptTemplate.jpg")
	draw = ImageDraw.Draw(img)

	font = ImageFont.truetype("Helvetica.ttf", 24)
	titleFont = ImageFont.truetype("Helvetica.ttf", 32)
	headerFont = ImageFont.truetype("Helvetica.ttf", 26)
	# draw.text((x, y),"Sample Text",(r,g,b))
	# x, y is the top-left coordinate
	draw.text((125, 365), customerName,(0,0,0), font=font)
	draw.text((300, 450), 'Receipt from Odyssey',(0,0,0), font=titleFont)
	draw.text((175, 525), 'Amount Paid', (0,0,0), font=headerFont)
	draw.text((550, 525), 'Date Paid',(0,0,0), font=headerFont)
	draw.text((175, 575), '$' + amountPaid,(0,0,0), font=font)
	draw.text((550, 575), datePaid,(0,0,0), font=font)
	draw.text((125, 700), 'If you have any questions, contact us at',(0,0,0), font=font)
	draw.text((125, 725), 'enquiries@odyssey.com, or call +65 9762 4351',(0,0,0), font=font)
	
	filename = "Receipt.jpg"
	img.save(filename)
	return filename

def createPayment(customerName):
	img = Image.open("paymentConfirmation.jpg")
	draw = ImageDraw.Draw(img)

	font = ImageFont.truetype("Helvetica.ttf", 24)

	draw.text((125, 365), customerName,(0,0,0), font=font)
	draw.text((175, 450), 'This email is to notify your payment for the itinerary',(0,0,0), font=font)
	draw.text((175, 475), 'is successful!',(0,0,0), font=font)
	draw.text((175, 525), 'We hope you have a great day ahead!',(0,0,0), font=font)

	filename = "Payment.jpg"
	img.save(filename)
	return filename