FROM python:3-slim
WORKDIR /usr/src/app
COPY amqp.reqs.txt ./
RUN pip install --no-cache-dir -r amqp.reqs.txt
COPY ./notification_payment.py ./rabbitMQSetup.py ./credentials.json ./token.json ./
CMD [ "python", "./notification_payment.py" ]