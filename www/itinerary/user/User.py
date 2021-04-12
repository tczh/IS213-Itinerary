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
        return dto

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

if __name__ == '__main__':
    print("This is flask for " + os.path.basename(__file__) + ": manage orders ...")
    app.run(host='0.0.0.0', port=5013, debug=True)
