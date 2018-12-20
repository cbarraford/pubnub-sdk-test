FROM scottw/alpine-perl
MAINTAINER Chad Barraford

RUN apk update && apk upgrade && \
    apk add --no-cache openssl openssl-dev

ADD https://github.com/pubnub/pubnub-api/raw/master/perl5/Pubnub.pm /usr/local/lib/perl5/5.26.2

RUN cpanm install Modern::Perl LWP::Simple LWP::Protocol::https JSON

CMD ["perl", "test.pl"]
