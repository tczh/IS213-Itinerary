FROM python:3-slim
WORKDIR /usr/src/app
COPY ./requirements/amqp.reqs.txt ./requirements/http.reqs.txt ./
RUN pip install --no-cache-dir -r amqp.reqs.txt -r http.reqs.txt
COPY ./itinerary_approval/itinerary_approval.py ./rabbitMQSetup.py ./invokes.py ./
CMD [ "python", "./itinerary_approval.py" ]