FROM python:3-slim
WORKDIR /usr/src/app
COPY ./requirements/http.reqs.txt ./requirements/futures.reqs.txt ./
RUN pip install --no-cache-dir -r http.reqs.txt -r futures.reqs.txt
COPY ./itinerary_display/itinerary_display.py ./invokes.py ./
CMD [ "python", "./itinerary_display.py" ]