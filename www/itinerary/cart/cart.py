import os
from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from sqlalchemy import Column, Integer, Text

from datetime import datetime
import json
from os import environ

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL') or 'mysql+mysqlconnector://root@localhost:3306/cart'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
app.config['SQLALCHEMY_ENGINE_OPTIONS'] = {'pool_recycle': 299}

db = SQLAlchemy(app)
CORS(app)  

class Cart(db.Model):
    __tablename__ = 'cart'

    cartID = db.Column(db.Integer, primary_key=True)
    emailAddr = db.Column(db.String(50), nullable=False)

    def __init__(self, cartID, emailAddr):
        self.cartID = cartID
        self.emailAddr = emailAddr

    def json(self):
        dto = {
            'cartID': self.cartID,
            'emailAddr': self.emailAddr
        }

        dto['cartItems'] = []
        for oi in self.cartItems:
            dto['cartItems'].append(oi.json())

        return dto

class CartItems(db.Model):
    __tablename__ = 'cartItems'

    cartNo = db.Column(db.Integer, primary_key=True)
    cartID = db.Column(db.ForeignKey('cart.cartID', ondelete='CASCADE', onupdate='CASCADE'), nullable=False, primary_key=True)
    itineraryID = db.Column(db.Integer, nullable=False)
    price = db.Column(db.Float(precision=2), nullable=False)
    tourtitle = db.Column(db.String(100), nullable=False)


    cart = db.relationship(
        'Cart', primaryjoin='CartItems.cartID == Cart.cartID', backref='cartItems')

    def json(self):
        return {'cartNo': self.cartNo, 'cartID': self.cartID, 'itineraryID': self.itineraryID, 'price': self.price, 'tourtitle': self.tourtitle}


@app.route("/cart")
def get_all():
    cartlist = Cart.query.all()
    if len(cartlist):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "cartlist": [cart.json() for cart in cartlist]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "There are no orders."
        }
    ), 404


@app.route("/cart/<string:cartID>")
def find_by_cart_id(cartID):
    cartItemsList = CartItems.query.filter_by(cartID=cartID).all()

    if not cartItemsList:
        return jsonify(
            {
                "code": 404,
                "data": {
                    "cartID": cartID
                },
                "message": "Cart not found."
            }
        ), 404

    if len(cartItemsList):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "cartItems":[cartItems.json() for cartItems in cartItemsList]
                }
            }
        )


@app.route("/deleteAll", methods=['POST'])
def find_all_everything():
    jsondatas = request.get_json()
    cart = CartItems.query.filter_by(itineraryID=jsondatas['itineraryID'], cartID=jsondatas['cartID']).first()
    db.session.delete(cart)
    db.session.commit()
    if cart:
        return jsonify(
            {
                "code": 200
            }
        )
    return jsonify(
        {
            "code": 404,
            "data": {
                "itineraryID": itineraryID
            },
            "message": "Review not found."
        }
    ), 404

@app.route("/cart", methods=["DELETE"])
def deleteCartItems():
    jsonData = request.get_json()
    cartID = jsonData["cartID"]
    cartItemsList = CartItems.query.filter_by(cartID=cartID).all()

    if not cartItemsList:
        return jsonify(
            {
                "code": 404,
                "data": {
                    "cartID": cartID
                },
                "message": "Cart not found."
            }
        ), 404

    for cartItems in cartItemsList:
        db.session.delete(cartItems)
        db.session.commit()

    cart = Cart.query.filter_by(cartID=cartID).first()
    db.session.delete(cart)
    db.session.commit()

    return jsonify(
        {
            "code": 200,
            "status": "Successfully Deleted!"
        }
    )
@app.route("/cart/insert", methods=['POST'])
def add_to_cart():
    emailAddr = request.get_json()["emailaddr"]
    itineraryID = request.get_json()["itineraryid"]
    price = request.get_json()["price"]
    tourtitle = request.get_json()["tourtitle"]

    if (Cart.query.filter_by(emailAddr=emailAddr).first()):
        cartID = Cart.query.filter_by(emailAddr=emailAddr).first().cartID
        check = CartItems.query.filter_by(cartID=cartID,itineraryID=itineraryID).first()
        if check:
            return jsonify(
                {
                    "code": 400,
                    "message": "Itinerary already exists in cart."
                }
            )
    else:
        #cart creation
        cart = Cart(cartID=None, emailAddr=emailAddr)
        try:
            db.session.add(cart)
            db.session.commit()
        except Exception as e:
            return jsonify(
                {
                    "code": 500,
                    "message": "An error occurred while creating the cart. " + str(e)
                }
            ), 500

        print(json.dumps(cart.json(), default=str)) # convert a JSON object to a string and print

    cartID = Cart.query.filter_by(emailAddr=emailAddr).first().cartID
    cartlist = Cart.query.filter_by(emailAddr=emailAddr).first()
    cartitems = CartItems(cartID=cartID,cartNo=None, itineraryID=itineraryID, price=price, tourtitle=tourtitle)
    
    try:
        db.session.add(cartitems)
        db.session.commit()
    except Exception as e:
        return jsonify(
            {
                "code": 500,
                "message": "An error occurred while adding the cart items. " + str(e)
            }
        ), 500
    #return json.dumps(cartitems.json(), default=str)# convert a JSON object to a string and print
    return jsonify(
        {
            "code": 201,
            "message": "Item has been sucessfully added into cart"
        }
    ), 201


@app.route("/delcart/<int:itineraryID>", methods=['GET'])
def delete_cart(itineraryID):
    cartitems = CartItems.query.filter_by(itineraryID=itineraryID).first()
    if cartitems:
        db.session.delete(cartitems)
        db.session.commit()
        return jsonify(
            {
                "code": 200,
                "data": {
                    "itineraryid": itineraryID
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "data": {
                "itineraryid": itineraryID
            },
            "message": "Review not found."
        }
    ), 404

@app.route("/allcartitems/<string:emailAddr>")
def find_by_email(emailAddr):
    cart = Cart.query.filter_by(emailAddr=emailAddr).first()
    if cart:
        return jsonify(
            {
                "code": 200,
                "data": cart.json()
            }
        )
    return jsonify(
        {
            "code": 404,
            "data": {
                "emailaddr": emailAddr
            },
            "message": "Order not found."
        }
    ), 404

@app.route("/cartitems/<string:emailAddr>")
def get_all_items_by_Email():
    cartlist = CartItems.filter_by(emailAddr=emailAddr)
    if len(cartlist):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "cartlist": [cart.json() for cart in cartlist]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "There are no orders."
        }
    ), 404

if __name__ == '__main__':
    print("This is flask for " + os.path.basename(__file__) + ": manage cart ...")
    app.run(host='0.0.0.0', port=5015, debug=True)