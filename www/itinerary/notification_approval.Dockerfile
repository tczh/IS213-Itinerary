FROM python:3-slim
WORKDIR /usr/src/app
COPY amqp.reqs.txt ./
RUN pip install --no-cache-dir -r amqp.reqs.txt
COPY ./notification_approval.py ./rabbitMQSetup.py ./credentials.json ./token.json ./
CMD [ "python", "./notification_approval.py" ]