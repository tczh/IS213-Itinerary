FROM python:3-slim
WORKDIR /usr/src/app
COPY ./requirements/amqp.reqs.txt ./
RUN pip install --no-cache-dir -r amqp.reqs.txt
COPY ./notification/notification.py ./imageCompose.py ./gmailCompose.py ./rabbitMQSetup.py ./credentials.json ./token.json ./
COPY ./font/Helvetica.ttf ./images/paymentConfirmation.jpg ./images/approvalTemplate.jpg ./
CMD [ "python", "./notification.py" ]