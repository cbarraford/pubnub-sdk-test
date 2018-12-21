FROM erlang:alpine
MAINTAINER Chad Barraford

RUN apk update && apk upgrade && \
    apk add --no-cache git

COPY entrypoint.sh /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]

# erlc test.erl && erl -noshell -s test start -s init stop
CMD ["erl", "-noshell", "-s", "test", "start", "-s", "init", "stop"]
