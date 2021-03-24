from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/review'
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
    reviewlist = Review.query.all()
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