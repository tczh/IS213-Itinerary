FROM python:3-slim
WORKDIR /usr/src/app
COPY ./requirements/http.reqs.txt ./
RUN pip install --no-cache-dir -r http.reqs.txt
COPY ./user/User.py ./
CMD [ "python", "./User.py" ]