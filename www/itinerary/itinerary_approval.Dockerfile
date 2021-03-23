FROM python:3-slim
WORKDIR /usr/src/app
COPY amqp.reqs.txt http.reqs.txt ./
RUN pip install --no-cache-dir -r amqp.reqs.txt -r http.reqs.txt
COPY ./itinerary_approval.py ./rabbitMQSetup.py ./credentials.json ./token.json ./
CMD [ "python", "./itinerary_approval.py" ]