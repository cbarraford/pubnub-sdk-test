FROM python:alpine
MAINTAINER Chad Barraford

RUN apk update && apk upgrade && \
    apk add --no-cache build-base

RUN pip install 'pubnub>=4.1.2'

CMD ["python", "test.py"]
