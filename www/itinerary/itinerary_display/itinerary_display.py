from flask import Flask, request, jsonify
from flask_cors import CORS

import os
from os import environ

import requests
from invokes import invoke_http
from requests_futures.sessions import FuturesSession

app = Flask(__name__)
CORS(app)

itinerary_URL = environ.get('itinerary_URL') or "http://localhost:5010/itinerary/"
itinerary_detail_URL = environ.get('itinerary_detail_URL') or "http://localhost:5010/itinerary/itinerarydetails/"
review_URL = environ.get('review_URL') or "http://localhost:5011/review/"


@app.route("/itinerary_display", methods=['POST'])
def display_itinerary():
    # Simple check of input format and data of the request are JSON
    if request.is_json:
        try:
            itineraryid = request.get_json()
            print("\nReceived an order in JSON:", itineraryid)
            # do the actual work
            # 1. Send itinerary info {itineraryid}
            result = processDisplayItinerary(itineraryid)
            return jsonify(result), result["code"]

        except Exception as e:
            pass  # do nothing.
    # if reached here, not a JSON request.
    return jsonify({
        "code": 400,
        "message": "Invalid JSON input: " + str(request.get_data())
    }), 400

def processDisplayItinerary(itineraryid):
    # 2. Send the itinerary info {itinerary}
    # Invoke the itinerary microservice
    session = FuturesSession()
    print('\n-----Invoking microservices-----')
    searchid = str(itineraryid['itineraryid'])
    future_one = session.get(itinerary_URL + searchid)
    future_two = session.get(itinerary_detail_URL + searchid)
    future_three = session.get(review_URL + searchid)
    
    response_one = future_one.result().json()
    print('itinerary_info:', response_one)

    #get itinerary details
    response_two = future_two.result().json()
    print('itinerarydetails_info:', response_two)

    #get review details
    response_three = future_three.result().json()    
    print('review_info:', response_three)

    #get itinerary country
    country = response_one["data"]["country"]

    #openweatherapi
    print('\n-----Invoking openweather & gnews api-----')
    openweatherapikey = '6afc1289d7b063832a4e808bfea98ad4'
    future_four = session.get("http://api.openweathermap.org/data/2.5/weather?q=" + country + "&units=metric&appid=" + openweatherapikey)
    

    #newsapi
    newsapikey = 'a577937e347ce3ca315c6f80db46276a'
    future_five = session.get("https://gnews.io/api/v4/search?q=" + country + " travel&lang=en&token=" + newsapikey)
    response_four = future_four.result().json()  
    print('weather_info:', response_four)
    response_five = future_five.result().json()  
    print('news_info:', response_five)

    return {
        "code": 201,
        "data": {
            "itinerary_info": response_one,
            "itinerarydetails_info": response_two,
            "review_info": response_three,
            "weather_info":response_four,
            "news_info": response_five
        }
    }    


if __name__ == "__main__":
    print("This is flask " + os.path.basename(__file__) +
          " for displaying itinerary...")
    app.run(host="0.0.0.0", port=5200, debug=True)