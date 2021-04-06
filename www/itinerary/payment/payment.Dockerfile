FROM python:3-slim
WORKDIR /usr/src/app
COPY ./requirements/http.reqs.txt ./requirements/stripe.reqs.txt ./
RUN pip install --no-cache-dir -r http.reqs.txt -r stripe.reqs.txt
COPY ./payment/payment.py ./
CMD [ "python", "./payment.py" ]