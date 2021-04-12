FROM python:3-slim
WORKDIR /usr/src/app
COPY ./requirements/http.reqs.txt ./
RUN pip install --no-cache-dir -r http.reqs.txt
COPY ./retrieve_purchased_itineraries/retrieve_purchased_itineraries.py ./invokes.py ./
CMD [ "python", "./retrieve_purchased_itineraries.py" ]