FROM golang:alpine
MAINTAINER Chad Barraford

RUN apk update && apk upgrade && \
    apk add --no-cache git

RUN go get github.com/pubnub/go

CMD ["go", "run", "test.go"]
