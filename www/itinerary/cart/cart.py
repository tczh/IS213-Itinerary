import os
from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS

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


# @app.route("/order")
# def get_all():
#     orderlist = Order.query.all()
#     if len(orderlist):
#         return jsonify(
#             {
#                 "code": 200,
#                 "data": {
#                     "orders": [order.json() for order in orderlist]
#                 }
#             }
#         )
#     return jsonify(
#         {
#             "code": 404,
#             "message": "There are no orders."
#         }
#     ), 404

# @app.route("/order/<string:order_id>")
# def find_by_order_id(order_id):
#     order = Order.query.filter_by(order_id=order_id).first()
#     if order:
#         return jsonify(
#             {
#                 "code": 200,
#                 "data": order.json()
#             }
#         )
#     return jsonify(
#         {
#             "code": 404,
#             "data": {
#                 "order_id": order_id
#             },
#             "message": "Order not found."
#         }
#     ), 404

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

# @app.route("/cart", methods=['POST'])
# def create_order():
#     customer_id = request.json.get('customer_id', None)
#     order = Order(customer_id=customer_id, status='NEW')

#     cart_item = request.json.get('cart_item')
#     for item in cart_item:
#         order.order_item.append(Order_Item(
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


# @app.route("/order/<string:order_id>", methods=['PUT'])
# def update_order(order_id):
#     try:
#         order = Order.query.filter_by(order_id=order_id).first()
#         if not order:
#             return jsonify(
#                 {
#                     "code": 404,
#                     "data": {
#                         "order_id": order_id
#                     },
#                     "message": "Order not found."
#                 }
#             ), 404

#         # update status
#         data = request.get_json()
#         if data['status']:
#             order.status = data['status']
#             db.session.commit()
#             return jsonify(
#                 {
#                     "code": 200,
#                     "data": order.json()
#                 }
#             ), 200
#     except Exception as e:
#         return jsonify(
#             {
#                 "code": 500,
#                 "data": {
#                     "order_id": order_id
#                 },
#                 "message": "An error occurred while updating the order. " + str(e)
#             }
#         ), 500


@app.route("/cart/insert", methods=['POST'])
def create_review():
    emailAddr = request.get_json()["emailaddr"]
    itineraryID = request.get_json()["itineraryid"]
    price = request.get_json()["price"]
    tourtitle = request.get_json()["tourtitle"]

    if (Cart.query.filter_by(emailAddr=emailAddr).first()):
        if (CartItems.query.filter_by(itineraryID=itineraryID).first()):
            return jsonify(
                {
                    "code": 400,
                    "message": "Itinerary already exists in cart."
                }
            ), 400
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

if __name__ == '__main__':
    print("This is flask for " + os.path.basename(__file__) + ": manage cart ...")
    app.run(host='0.0.0.0', port=5015, debug=True)