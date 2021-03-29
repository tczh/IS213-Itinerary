import os
from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS

from sqlalchemy.sql import expression
from datetime import datetime
import json
from os import environ
import stripe

stripe.api_key = "sk_test_51IY8rSKA7uVreypX3jBpmxZaxWMfkYujClys1oEHmVL5YePUPf4STe3DsrwoqUNJJ9ChEsFbLE81nVuURPt0WQXC00L97q1rWq"

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL') or 'mysql+mysqlconnector://root@localhost:3306/payment'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
app.config['SQLALCHEMY_ENGINE_OPTIONS'] = {'pool_recycle': 299}

db = SQLAlchemy(app)
CORS(app)

class Payment(db.Model):
    __tablename__ = 'payment'

    paymentID = db.Column(db.Integer, primary_key=True)
    emailAddr = db.Column(db.String(50), nullable=False)
    isPaid = db.Column(db.String(5), nullable=False)
    dateBought = db.Column(db.DateTime, nullable=False, default=datetime.now)
    totalPrice = db.Column(db.Float(precision=2), nullable=False)

    def json(self):
        dto = {
            'paymentID': self.paymentID,
            'emailAddr': self.emailAddr,
            'isPaid': self.isPaid,
            'dateBought': self.dateBought,
            'totalPrice': self.totalPrice
        }

        dto['paymentItems'] = []
        for oi in self.paymentItems:
            dto['paymentItems'].append(oi.json())

        return dto

class PaymentItems(db.Model):
    __tablename__ = 'paymentItems'

    orderNo = db.Column(db.Integer, nullable=False, primary_key=True)
    paymentID = db.Column(db.ForeignKey('payment.paymentID', ondelete='CASCADE', onupdate='CASCADE'), nullable=False, primary_key=True)
    itineraryID = db.Column(db.Integer, nullable=False)

    payment = db.relationship(
        'Payment', primaryjoin='PaymentItems.paymentID == Payment.paymentID', backref='paymentItems')

    def json(self):
        return {'orderNo': self.orderNo, 'paymentID': self.paymentID, 'itineraryID': self.itineraryID}

@app.route("/payment", methods=['POST'])
def create_payment():
    emailAddr = request.json.get('emailAddr')
    totalPrice = request.json.get('totalPrice')
    payment = Payment(emailAddr=emailAddr, totalPrice=totalPrice, isPaid='False')

    cartItems = request.json.get('cartItems')
    for item in cartItems:
        payment.paymentItems.append(PaymentItems(
            itineraryID=item['itineraryID']))

    try:
        db.session.add(payment)
        db.session.commit()
    except Exception as e:
        return jsonify(
            {
                "code": 500,
                "message": "An error occurred while creating the payment. " + str(e)
            }
        ), 500
    
    print(json.dumps(payment.json(), default=str)) # convert a JSON object to a string and print
    print()

    return jsonify(
        {
            "code": 201,
            "data": payment.json()
        }
    ), 201

@app.route("/createPaymentIntent", methods=['POST'])
def createPaymentIntent():
    data = json.loads(request.data)
    # Create a PaymentIntent with the order amount and currency
    intent = stripe.PaymentIntent.create(
        amount=data['totalPrice'],
        currency=data['currency']
    )

    try:
        # Send publishable key and PaymentIntent details to client
        return jsonify({'publishableKey': data['key'], 'clientSecret': intent.client_secret})
    except Exception as e:
        return jsonify(error=str(e)), 403

@app.route("/payment", methods=['PUT'])
def update_payment():
    try:
        data = request.get_json()
        print(data)
        paymentID = data["paymentID"]
        payment = Payment.query.filter_by(paymentID=paymentID).first()
        if not payment:
            return jsonify(
                {
                    "code": 404,
                    "data": {
                        "paymentID": paymentID
                    },
                    "message": "Payment not found."
                }
            ), 404

        # update payment
        payment.isPaid = 'True'
        db.session.commit()

        return jsonify(
            {
                "code": 200,
                "data": payment.json()
            }
        ), 200

    except Exception as e:
        return jsonify(
            {
                "code": 500,
                "data": {
                    "paymentID": paymentID
                },
                "message": "An error occurred while updating the payment. " + str(e)
            }
        ), 500

if __name__ == '__main__':
    print("This is flask for " + os.path.basename(__file__) + ": manage payment ...")
    app.run(host='0.0.0.0', port=5016, debug=True)
