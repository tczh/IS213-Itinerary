FROM python:3-slim
WORKDIR /usr/src/app
COPY ./requirements/http.reqs.txt ./requirements/futures.reqs.txt ./
RUN pip install --no-cache-dir -r http.reqs.txt -r futures.reqs.txt
COPY ./retrieve_itinerary_details/retrieve_itinerary_details.py ./invokes.py ./
CMD [ "python", "./retrieve_itinerary_details.py" ]