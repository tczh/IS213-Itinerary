FROM python:3-slim
WORKDIR /usr/src/app
COPY ./amqp.reqs.txt ./http.reqs.txt ./
RUN pip install --no-cache-dir -r amqp.reqs.txt -r http.reqs.txt
COPY ./purchase_itinerary/purchase_itinerary.py ./rabbitMQSetup.py ./
CMD [ "python", "./purchase_itinerary.py" ]