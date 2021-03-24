from PIL import Image
from PIL import ImageFont
from PIL import ImageDraw 

def createIMG(customerName, itemID, statusType):
	img = Image.open("template.jpg")
	draw = ImageDraw.Draw(img)

	font = ImageFont.truetype("Helvetica.ttf", 36)
	# draw.text((x, y),"Sample Text",(r,g,b))
	# x, y is the top-left coordinate
	draw.text((200, 560), customerName,(0,0,0), font=font)
	draw.text((750, 560), itemID,(0,0,0), font=font)

	if (statusType == "Approval"):
		draw.text((200, 750), 'This email is to notify you that your itinerary has been',(0,0,0), font=font)
		draw.text((200, 800), 'approved!',(0,0,0), font=font)
		draw.text((200, 900), 'We hope you have a great day ahead!',(0,0,0), font=font)
		filename = "Approval.jpg"
	else:
		draw.text((200, 750), 'This email is to notify your payment for the itinerary',(0,0,0), font=font)
		draw.text((200, 800), 'is successful!',(0,0,0), font=font)
		draw.text((200, 900), 'We hope you have a great day ahead!',(0,0,0), font=font)
		filename = "Payment.jpg"

	img.save(filename)

	return filename