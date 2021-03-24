from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/itinerary'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

CORS(app)  

class Itinerary(db.Model):
    __tablename__ = 'itinerary'

    itineraryid = db.Column(db.Integer, primary_key=True)
    itinerarycreator = db.Column(db.String(50), nullable=False)
    tourtitle = db.Column(db.String(100), nullable=False)
    tourcategory = db.Column(db.String(50), nullable=False)
    country = db.Column(db.String(50), nullable=False)
    price = db.Column(db.Float(precision=2), nullable=False)
    thumbnail = db.Column(db.String(1000), nullable=False)
    datetimecreated = db.Column(db.String(50), nullable=False)

    def __init__(self, itineraryid, itinerarycreator, tourtitle, tourcategory, country, price, thumbnail, datetimecreated):
        self.itineraryid = itineraryid
        self.itinerarycreator = itinerarycreator
        self.tourtitle = tourtitle
        self.tourcategory = tourcategory
        self.country = country
        self.price = price
        self.thumbnail = thumbnail
        self.datetimecreated = datetimecreated


    def json(self):
        return {"itineraryid": self.itineraryid, "itinerarycreator": self.itinerarycreator, "tourtitle": self.tourtitle, "tourcategory": self.tourcategory,  "country": self.country,  "price": self.price,  "thumbnail": self.thumbnail,  "datetimecreated": self.datetimecreated}

class ItineraryDetails(db.Model):
    __tablename__ = 'itinerarydetails'
    detailsid = db.Column(db.Integer, primary_key=True)
    itineraryid = db.Column(db.Integer, primary_key=True)
    location = db.Column(db.String(200), nullable=False)
    date = db.Column(db.String(50), nullable=False)
    timestart = db.Column(db.String(50), nullable=False)
    timeend = db.Column(db.String(50), nullable=False)
    activity = db.Column(db.String(50), nullable=False)
    description = db.Column(db.String(500), nullable=False)

    def __init__(self, detailsid, itineraryid, location, date, timestart, timeend, activity, description):
        self.detailsid = detailsid
        self.itineraryid = itineraryid
        self.location = location
        self.date = date
        self.timestart = timestart
        self.timeend = timeend
        self.activity = activity
        self.description = description


    def json(self):
        return {"detailsid": self.detailsid, "itineraryid": self.itineraryid, "location": self.location, "date": self.date, "timestart": self.timestart, "timeend": self.timeend, "activity": self.activity,  "description": self.description}


@app.route("/itinerary")
def get_all():
    itinerarylist = Itinerary.query.all()
    if len(itinerarylist):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "itinerary": [itinerary.json() for itinerary in itinerarylist]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "There are no itineraries."
        }
    ), 404

@app.route("/itinerary/<int:itineraryid>")
def find_specific_itinerary(itineraryid):
    itinerary = Itinerary.query.filter_by(itineraryid=itineraryid).first()
    if itinerary:
        return jsonify(
            {
                "code": 200,
                "data": itinerary.json()
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "Itinerary information not found."
        }
    ), 404

@app.route("/itinerary/itinerarydetails/<int:itineraryid>")
def find_specific_itinerarydetails(itineraryid):
    itinerarydetailslist = ItineraryDetails.query.filter_by(itineraryid=itineraryid).all()
    if len(itinerarydetailslist):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "itinerarydetails": [itinerarydetails.json() for itinerarydetails in itinerarydetailslist]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "Itinerary Details not found."
        }
    ), 404


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5010, debug=True)