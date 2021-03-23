from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from os import environ
from flask_cors import CORS

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')or 'mysql+mysqlconnector://root@localhost:3306/Review'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
app.config['SQLALCHEMY_ENGINE_OPTIONS'] = {'pool_recycle': 299}

db = SQLAlchemy(app)

CORS(app)

class Review(db.Model):
    __tablename__ = 'Review'
    ReviewID = db.Column(db.Integer, primary_key=True)
    ItineraryCreator = db.Column(db.String(50), primary_key=True)
    TourTitle = db.Column(db.String(100), nullable=False)
    Country = db.Column(db.String(50), nullable=False)
    Season = db.Column(db.String(10), nullable=False)
    Price = db.Column(db.Float(precision=2), nullable=False)
    Thumbnail = db.Column(db.String(1000), nullable=False)
    DateTimeCreated = db.Column(db.TIMESTAMP(6), nullable=False)
    HasApproved = db.Column(db.VARCHAR(1), nullable=False)

    def __init__(self, ReviewID, ItineraryCreator, TourTitle, Country,Season, Price, Thumbnail, DateTimeCreated, HasApproved):
        self.ReviewID = ReviewID
        self.ItineraryCreator = ItineraryCreator
        self.TourTitle = TourTitle
        self.Country = Country
        self.Season = Season
        self.Price = Price
        self.Thumbnail = Thumbnail
        self.DateTimeCreated = DateTimeCreated
        self.HasApproved = HasApproved

    def json(self):
        return {"ReviewID": self.ReviewID, "ItineraryCreator": self.ItineraryCreator, "TourTitle": self.TourTitle, "Country": self.Country,
        "Season":self.Season,"Season":self.Season,"Thumbnail":self.Thumbnail,"DateTimeCreated":self.DateTimeCreated,"HasApproved":self.HasApproved}


@app.route("/Review")
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


@app.route("/Review/<int:ReviewID>")
def find_by_reviewID(ReviewID):
    review = Review.query.filter_by(ReviewID=ReviewID).first()
    if review:
        return jsonify(
            {
                "code": 200,
                "data": review.json()
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "Review not found."
        }
    ), 404


@app.route("/Review/<int:ReviewID>", methods=['POST'])
def create_review(isbn13):
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

    data = request.get_json()
    review = Review(ReviewID, **data)

    try:
        db.session.add(review)
        db.session.commit()
    except:
        return jsonify(
            {
                "code": 500,
                "data": {
                    "ReviewID": ReviewID
                },
                "message": "An error occurred creating the book."
            }
        ), 500

    return jsonify(
        {
            "code": 201,
            "data": review.json()
        }
    ), 201

@app.route("/Review/<int:ReviewID>", methods=['PUT'])
def update_review(ReviewID):
    review = Review.query.filter_by(ReviewID=ReviewID).first()
    if review:
        data = request.get_json()
        if data['ItineraryCreator']:
            review.ItineraryCreator = data['ItineraryCreator']
        if data['TourTitle']:
            review.price = data['TourTitle']
        if data['Country']:
            review.Country = data['Country']
        if data['Season']:
            review.Season = data['Season']
        if data['Thumbnail']:
            review.Thumbnail = data['Thumbnail']
        if data['DateTimeCreated']:
            review.DateTimeCreated = data['DateTimeCreated']
        if data['HasApproved']:
            review.HasApproved = data['HasApproved']
         
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


@app.route("/Review/<int:ReviewID>", methods=['DELETE'])
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


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
