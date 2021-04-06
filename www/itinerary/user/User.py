#!/usr/bin/env python3
# The above shebang (#!) operator tells Unix-like environments
# to run this file as a python3 script

import os
from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from sqlalchemy import Column, Integer, Text

from datetime import datetime
import json
from os import environ

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL') or 'mysql+mysqlconnector://root@localhost:3306/user'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
app.config['SQLALCHEMY_ENGINE_OPTIONS'] = {'pool_recycle': 299}

db = SQLAlchemy(app)

CORS(app)  

class User(db.Model):
    __tablename__ = 'user'

    emailaddr = db.Column(db.String(50), primary_key=True)
    phonenumber = db.Column(db.Integer, nullable=False)
    firstname = db.Column(db.String(50), nullable=False)
    lastname = db.Column(db.String(30), nullable=False)
    password = db.Column(db.String(20), nullable=False)
    country = db.Column(db.String(50), nullable=False)
    address = db.Column(db.String(100), nullable=False)
    role = db.Column(db.String(50), nullable=False)

    def __init__(self, emailaddr, phonenumber, firstname, lastname, password, country, address, role):
        self.emailaddr = emailaddr
        self.phonenumber = phonenumber
        self.firstname = firstname
        self.lastname = lastname
        self.password = password
        self.country = country
        self.address = address
        self.role = role
    
    def json(self):
        dto = {
            'emailaddr': self.emailaddr,
            'phonenumber': self.phonenumber,
            'firstname': self.firstname,
            'lastname': self.lastname,
            'password': self.password,
            'country': self.country,
            'address': self.address,
            'role': self.role
        }

        # dto['customersList'] = []
        # for oi in self.customersList:
        #     dto['customers'].append(oi.json())

        return dto



# class CartItems(db.Model):
#     __tablename__ = 'cartitems'

#     CartNo = db.Column(db.Integer, primary_key=True)
#     ItineraryID = db.Column(db.Integer, nullable=False)

#     CartID = db.Column(db.ForeignKey(
#         'cart.CartID', ondelete='CASCADE', onupdate='CASCADE'), nullable=False, index=True)
#     # order = db.relationship('Order', backref='order_item')
#     cart = db.relationship(
#        'Cart', primaryjoin='CartItems.CartID == Cart.CartID', backref='cartitems')
#     def json(self):
#         return {'CartNo': self.CartNo, 'CartID': self.CartID, 'ItineraryID': self.ItineraryID}


@app.route("/user")
def get_all():
    userList = User.query.all()
    if len(userList):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "user": [user.json() for user in userList]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "There are no users."
        }
    ), 404


@app.route("/user/<string:emailaddr>")
def individual_user(emailaddr):
    user = User.query.filter_by(emailaddr=emailaddr).first()
    if user is not None:
        return jsonify(
            {
                "code": 200,
                "data": {
                    "user": user.json()
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "data": {
                "user": emailaddr
            },
            "message": "Email address not found."
        }
    ), 404

@app.route("/createuser", methods=['POST'])
def create_user():
    data = request.get_json()
    emailaddr =data['emailaddr']
    if (User.query.filter_by(emailaddr=emailaddr).first()):
        return jsonify(
            {
                "code": 400,
                "data": {
                    "emailaddr": emailaddr
                },
                "message": "User already exists."
            }
        ), 400

    phonenumber =data['phonenumber']
    firstname =data['firstname']
    lastname =data['lastname']
    password =data['password']
    country =data['country']
    address =data['address']
    role =data['role']
    user = User(emailaddr=emailaddr, phonenumber=phonenumber, firstname=firstname, lastname=lastname, password=password, country=country, address=address, role=role)

    try:
        db.session.add(user)
        db.session.commit()
    except:
        return jsonify(
            {
                "code": 500,
                "data": {
                    "emailaddr": emailaddr
                },
                "message": "An error occurred creating the user."
            }
        ), 500

    return jsonify(
        {
            "code": 201,
            "data": user.json()
        }
    ), 201

# @app.route("/delcart/<int:ItineraryID>", methods=['GET'])
# def delete_cart(ItineraryID):
#     cartitems = CartItems.query.filter_by(ItineraryID=ItineraryID).first()
#     if cartitems:
#         db.session.delete(cartitems)
#         db.session.commit()
#         return jsonify(
#             {
#                 "code": 200,
#                 "data": {
#                     "ItineraryID": ItineraryID
#                 }
#             }
#         )
#     return jsonify(
#         {
#             "code": 404,
#             "data": {
#                 "ItineraryID": ItineraryID
#             },
#             "message": "Review not found."
#         }
#     ), 404



# @app.route("/cartitems/<string:EmailAddr>")
# def get_all_items_by_Email():
#     cartlist = CartItems.filter_by(EmailAddr=EmailAddr)
#     if len(cartlist):
#         return jsonify(
#             {
#                 "code": 200,
#                 "data": {
#                     "cartlist": [cart.json() for cart in cartlist]
#                 }
#             }
#         )
#     return jsonify(
#         {
#             "code": 404,
#             "message": "There are no orders."
#         }
#     ), 404

# @app.route("/allcartitems/<string:EmailAddr>")
# def find_by_email(EmailAddr):
#     cart = Cart.query.filter_by(EmailAddr=EmailAddr).first()
#     if cart:
#         return jsonify(
#             {
#                 "code": 200,
#                 "data": cart.json()
#             }
#         )
#     return jsonify(
#         {
#             "code": 404,
#             "data": {
#                 "EmailAddr": EmailAddr
#             },
#             "message": "Order not found."
#         }
#     ), 404


# @app.route("/cart", methods=['POST'])
# def create_order():
#     EmailAddr = request.json.get('EmailAddr', None)
#     Cart = Cart(EmailAddr=EmailAddr)

#     cart_item = request.json.get('cart_item')
#     for item in cart_item:
#         cart.cart_item.append(CartItems(
#             book_id=item['book_id'], quantity=item['quantity']))

#     try:
#         db.session.add(order)
#         db.session.commit()
#     except Exception as e:
#         return jsonify(
#             {
#                 "code": 500,
#                 "message": "An error occurred while creating the order. " + str(e)
#             }
#         ), 500
    
#     print(json.dumps(order.json(), default=str)) # convert a JSON object to a string and print
#     print()

#     return jsonify(
#         {
#             "code": 201,
#             "data": order.json()
#         }
#     ), 201


# @app.route("/cart/<int:CartID>", methods=['PUT'])
# def update_order(CartID):
#     try:
#         cartItems = CartItems.query.filter_by(CartID=CartID).first()
#         if not cartItems:
#             return jsonify(
#                 {
#                     "code": 404,
#                     "data": {
#                         "CartID": CartID
#                     },
#                     "message": "Order not found."
#                 }
#             ), 404

#         # update status
#         data = request.get_json()
#         if data:
#             db.session.commit()
#             return jsonify(
#                 {
#                     "code": 200,
#                     "data": cartItems.json()
#                 }
#             ), 200
#     except Exception as e:
#         return jsonify(
#             {
#                 "code": 500,
#                 "data": {
#                     "CartID": CartID
#                 },
#                 "message": "An error occurred while updating the order. " + str(e)
#             }
#         ), 500


if __name__ == '__main__':
    print("This is flask for " + os.path.basename(__file__) + ": manage orders ...")
    app.run(host='0.0.0.0', port=5013, debug=True)
