from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
import json
import datetime
from os import environ

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL') or 'mysql+mysqlconnector://root@localhost:3306/review'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

CORS(app)  

class Review(db.Model):
    __tablename__ = 'review'

    reviewid = db.Column(db.Integer, primary_key=True)
    itineraryid = db.Column(db.Integer, nullable=False)
    emailaddr = db.Column(db.String(50), nullable=False)
    reviewrating = db.Column(db.Integer, nullable=False)
    reviewmessage = db.Column(db.String(100), nullable=False)
    reviewdatetime = db.Column(db.String(50), nullable=False)

    def __init__(self, reviewid, itineraryid, emailaddr, reviewrating, reviewmessage, reviewdatetime):
        self.reviewid = reviewid
        self.itineraryid = itineraryid
        self.emailaddr = emailaddr
        self.reviewrating = reviewrating
        self.reviewmessage = reviewmessage
        self.reviewdatetime = reviewdatetime

    def json(self):
        return {"reviewid": self.reviewid, "itineraryid": self.itineraryid, "emailaddr": self.emailaddr, "reviewrating": self.reviewrating,  "reviewmessage": self.reviewmessage,  "reviewdatetime": self.reviewdatetime}


@app.route("/review")
def get_all():
    reviewlist = Review.query.order_by(Review.itineraryid).all()
    if len(reviewlist):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "itinerary": [review.json() for review in reviewlist]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "There are no reviews."
        }
    ), 404

@app.route("/review/insert", methods=['POST'])
def create_review():
    emailaddr = request.get_json()["emailaddr"]
    itineraryid = request.get_json()["itineraryid"]
    if (Review.query.filter_by(emailaddr=emailaddr, itineraryid=itineraryid).first()):
        return jsonify(
            {
                "code": 400,
                "message": "Review already exists for this itinerary."
            }
        ), 400
    
    reviewrating = request.get_json()["reviewrating"]
    reviewmessage = request.get_json()["reviewmessage"]
    reviewdatetime =  datetime.datetime.now()
    review = Review(reviewid=None,emailaddr=emailaddr, itineraryid=itineraryid, reviewrating=reviewrating,reviewmessage=reviewmessage,reviewdatetime=reviewdatetime)
 
    try:
        db.session.add(review)
        db.session.commit()
    except Exception as e:
        return jsonify(
            {
                "code": 500,
                "message": "An error occurred while creating the review. " + str(e)
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

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5011, debug=True)