# IS213-Itinerary

Odyssey’s Itineraries is created as a platform to deliver the ease of travelling to the users. The main objective of the solution is to ensure that past itineraries will not go to waste while potential travellers can obtain itineraries easy and hassle free.
Planning for a trip takes a significant amount from as little as a few weeks to a longer period of a year or so. Part of the planning process involves sourcing for places to go to according to the goal of your trip. We aim to shorten this process for prospective travellers while allowing people to reuse their past itineraries.

<hr>

#### Itinerary Microservices Port Configuration
Itinerary Microservice Port 5010

Review Microservice Port 5011

User Microservice Port 5013

Cart Microservice Port 5015

Payment Microservice Port 5016

#### Itinerary Complex Microservices Port Configuration
Itinerary Approval Complex Microservice Port 5100

Retrieve Itinerary Details Complex Microservice Port 5200

Purchase Itinerary Complex Microservice Port 5300

Retrieve Purchased Itineraries Port 5400

#### Card Information For Payment
Country: Singapore (ASIA-PACIFIC)
Card Type: VISA
Card Number: 4000 0070 2000 0003
MM/YY: <Any number>
CVC: <Any number>

Country: United States (AMERICA)
Card Type: VISA
Card Number: 4242 4242 4242 4242
MM/YY: <Any number>
CVC: <Any number>
ZIP: <Any number> 

<hr>

# Installation Guide

We have provided a walkthrough video as well, therefore you could refer to that video instead of having to go through these installation steps.
Link to video walkthrough: https://youtu.be/ifqyyIt9cKk

To get Odyssey up and running on your system:

Ensure the following is turned on and running: WAMP/MAMP, Docker

You will need the following folder, itinerary, which contains the codes upon which Odyssey runs on. There are 2 ways to get the folder itinerary.

### Via Github
Clone the Repo (git clone https://github.com/tczh/IS213-Itinerary)
Navigate to the folder **IS213-Itinerary\www** to find itinerary folder

### Via elearn
Download itinerary.zip from elearn

<hr>

Move the itinerary folder into -> **wamp64\www\**<br>
Open a Terminal at **wamp64\www\itinerary**<br>
Run the command: **docker-compose up**, wait till command is executed completely<br>
Import the SQL files found at **wamp64\www\itinerary\sql** into your local database<br>

As our application uses the KONG API Gateway, there are some additional set-up steps before our application can be used.

## Setting up Kong
Through the browser, Access: http://localhost:1337<br>
Create a KONG admin account:
* Username: odyssey
* Email: \<any email address\>
* Password: odyssey

Sign in with the above credentials<br>
Create the connection
* Name: default
* Kong admin url: http://kong:8001

Create Services and Routes for all the microservices (Refer to Installation Guide with Images for a graphical tutorial)
* user
* review
* purchase_itinerary
* payment
* Itinerary_approval
* itinerary
* retrieve_purchased_itineraries
* retrieve_itinerary_details
* cart

**in addition to the methods GET/POST/PUT/DELETE in the routes, ensure that OPTIONS is also entered in the routes**

Odyssey is now functional and accessible at http://localhost/itinerary/

<hr>

### Installation Guide with Images

<a href="https://docs.google.com/document/d/1B8UpwwpCEISDQ5beiwhM2Buu-DJ4RwUOc1SsltrgILw/edit?usp=sharing">Click Here</a> for installation guide

<hr>

## Credentials
2 Accounts, Admin and Guest, have been created for purposes of demonstrating the functions of Odyssey's Itineraries. Their credentials can be found below.

Login using Admin:
* Email: admin@gmail.com
* Password: admin

To view itineraries available for approval.

Login using Guest:
* Email: guest@gmail.com
* Password: guest

Navigate to Account Tab to view purchased and created itineraries

Alternatively, you could create your own guest account (Google Login / Account Creation) or simply view the video walkthrough linked above, at the start of the Installation guide.
