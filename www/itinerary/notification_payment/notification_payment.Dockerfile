FROM python:3-slim
WORKDIR /usr/src/app
COPY ./amqp.reqs.txt ./
RUN pip install --no-cache-dir -r amqp.reqs.txt
COPY ./notification_payment/notification_payment.py ./imgCompose.py ./gmailCompose.py ./rabbitMQSetup.py ./credentials.json ./token.json ./
COPY ./font/Helvetica.ttf ./images/template.jpg ./
CMD [ "python", "./notification_payment.py" ]