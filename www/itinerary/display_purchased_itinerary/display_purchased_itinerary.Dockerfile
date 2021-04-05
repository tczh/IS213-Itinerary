FROM python:3-slim
WORKDIR /usr/src/app
COPY ./requirements/http.reqs.txt ./
RUN pip install --no-cache-dir -r http.reqs.txt
COPY ./display_purchased_itinerary/display_purchased_itinerary.py ./invokes.py ./
CMD [ "python", "./display_purchased_itinerary.py" ]