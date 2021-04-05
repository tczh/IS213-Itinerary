FROM python:3-slim
WORKDIR /usr/src/app
COPY ./requirements/http.reqs.txt ./
RUN pip install --no-cache-dir -r http.reqs.txt
COPY ./review/review.py ./
CMD [ "python", "./review.py" ]