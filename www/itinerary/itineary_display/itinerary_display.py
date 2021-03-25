from flask import Flask, request, jsonify
from flask_cors import CORS

import os

import requests
from invokes import invoke_http

app = Flask(__name__)
CORS(app)

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
    print('\n-----Invoking itinerary microservice-----')
    searchid = str(itineraryid['itineraryid'])
    itinerary_info = invoke_http("http://localhost:5010/itinerary/" + searchid, method='GET')
    print('itinerary_info:', itinerary_info)

    #get itinerary details
    itinerarydetails_info = invoke_http("http://localhost:5010/itinerary/itinerarydetails/" + searchid, method='GET')
    print('itinerarydetails_info:', itinerarydetails_info)

    #get review details
    print('\n-----Invoking review microservice-----')
    review_info = invoke_http("http://localhost:5011/review/" + searchid, method='GET')
    print('review_info:', review_info)

    #get itinerary country
    country = itinerary_info["data"]["country"]

    #openweatherapi
    print('\n-----Invoking openweather api-----')
    openweatherapikey = '6afc1289d7b063832a4e808bfea98ad4'
    weather_info = invoke_http("http://api.openweathermap.org/data/2.5/weather?q=" + country + "&units=metric&appid=" + openweatherapikey, method ='GET')
    print('weather_info:', weather_info)

    #newsapi
    print('\n-----Invoking gnews api-----')
    newsapikey = 'a577937e347ce3ca315c6f80db46276a'
    news_info = invoke_http("https://gnews.io/api/v4/search?q=" + country + " travel&lang=en&token=" + newsapikey, method ='GET')
    print('news_info:', news_info)

    return {
        "code": 201,
        "data": {
            "itinerary_info": itinerary_info,
            "itinerarydetails_info": itinerarydetails_info,
            "review_info": review_info,
            "weather_info":weather_info,
            "news_info": news_info
        }
    }    


if __name__ == "__main__":
    print("This is flask " + os.path.basename(__file__) +
          " for displaying itinerary...")
    app.run(host="0.0.0.0", port=5200, debug=True)
