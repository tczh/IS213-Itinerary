FROM python:3-slim
WORKDIR /usr/src/app
COPY ./requirements/amqp.reqs.txt ./requirements/http.reqs.txt ./
RUN pip install --no-cache-dir -r amqp.reqs.txt -r http.reqs.txt
COPY ./purchase_itinerary/purchase_itinerary.py ./invokes.py ./rabbitMQSetup.py ./images/receiptTemplate.jpg ./
COPY ./imageCompose.py ./gmailCompose.py ./font/Helvetica.ttf ./credentials.json ./token.json ./
CMD [ "python", "./purchase_itinerary.py" ]