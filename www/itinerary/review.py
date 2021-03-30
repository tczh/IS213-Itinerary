
import os
from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from datetime import datetime
import json
from os import environ

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/review'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
app.config['SQLALCHEMY_ENGINE_OPTIONS'] = {'pool_recycle': 299}

db = SQLAlchemy(app)

CORS(app)

class Review(db.Model):
    __tablename__ = 'review'
    ReviewID = db.Column(db.Integer, primary_key=True)
    EmailAddr = db.Column(db.String(50), nullable=False)
    ReviewRating = db.Column(db.Integer, nullable=False)
    ReviewMessage = db.Column(db.String(100), nullable=False)
    ReviewDateTime = db.Column(db.String(50), nullable=False)

    def json(self):
        dto = {
            'ReviewID': self.ReviewID,
            'EmailAddr': self.EmailAddr,
            'ReviewRating': self.ReviewRating,
            'ReviewMessage': self.ReviewMessage,
            'ReviewDateTime': self.ReviewDateTime
        }

        return dto


@app.route("/review")
def get_all():
    ReviewList = Review.query.all()
    if len(ReviewList):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "Reviews": [Review.json() for Review in ReviewList]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "There are no Reviews."
        }
    ), 404


@app.route("/review/<int:itineraryid>")
def find_details_by_id(itineraryid):
    reviewlist = Review.query.filter_by(itineraryid=itineraryid).all()
    if len(reviewlist):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "review": [review.json() for review in reviewlist]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "Reviews not found for itinerary."
        }
    ), 404


@app.route("/insertreview", methods=['POST'])
def create_review(ReviewID):
    if (Review.query.filter_by(ReviewID=ReviewID).first()):
        return jsonify(
            {
                "code": 400,
                "data": {
                    "ReviewID": ReviewID
                },
                "message": "Review already exists."
            }
        ), 400
    EmailAddr = request.get_json('EmailAddr')
    ReviewRating = request.get_json('ReviewRating')
    ReviewMessage = request.get_json('ReviewMessage')
    ReviewDateTime = request.get_json('ReviewDateTime')
    review = Review(EmailAddr=EmailAddr,ReviewRating=ReviewRating,ReviewMessage=ReviewMessage,ReviewDateTime=ReviewDateTime)

    try:
        db.session.add(review)
        db.session.commit()
    except Exception as e:
        return jsonify(
            {
                "code": 500,
                "message": "An error occurred while creating the payment. " + str(e)
            }
        ), 500
    print(json.dumps(review.json(), default=str)) # convert a JSON object to a string and print
    print()
    return jsonify(
        {
            "code": 201,
            "data": review.json()
        }
    ), 201

@app.route("/review/<int:ReviewID>", methods=['PUT'])
def update_review(ReviewID):
    review = Review.query.filter_by(ReviewID=ReviewID).first()
    if review:
        data = request.get_json()
        if data['EmailAddr']:
            review.ItineraryCreator = data['EmailAddr']
        if data['ReviewRating']:
            review.price = data['ReviewRating']
        if data['ReviewMessage']:
            review.Country = data['ReviewMessage']
        if data['ReviewDateTime']:
            review.Season = data['ReviewDateTime']
         
        db.session.commit()
        return jsonify(
            {
                "code": 200,
                "data": review.json()
            }
        )
    return jsonify(
        {
            "code": 404,
            "data": {
                "ReviewID": ReviewID
            },
            "message": "Review not found."
        }
    ), 404


@app.route("/review/<int:ReviewID>", methods=['DELETE'])
def delete_review(ReviewID):
    review = Review.query.filter_by(ReviewID=ReviewID).first()
    if review:
        db.session.delete(review)
        db.session.commit()
        return jsonify(
            {
                "code": 200,
                "data": {
                    "ReviewID": ReviewID
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "data": {
                "ReviewID": ReviewID
            },
            "message": "Review not found."
        }
    ), 404

@app.route("/reviewall/<string:EmailAddr>")
def find_by_email(EmailAddr):
    review = Review.query.filter_by(EmailAddr=EmailAddr).all()
    if len(review):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "review": [reviews.json() for reviews in review]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "data": {
                "EmailAddr": EmailAddr
            },
            "message": "Order not found."
        }
    ), 404
#Create one more microservices function that checks if itineraryid & emailaddr is inside that review db, if inside cannot review

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5011, debug=True)
#itinerary = 5010
