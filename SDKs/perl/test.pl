## ---------------------------------------------------
##
## YOU MUST HAVE A PUBNUB ACCOUNT TO USE THE API.
## http://www.pubnub.com/account
##
## ----------------------------------------------------

## --------------------------------------------
## PubNub 3.0 Real-time Cloud Push API - PERL 5
## --------------------------------------------
##
## www.pubnub.com - PubNub Real-time Push Service in the Cloud. 
## http://github.com/pubnub/pubnub-api/tree/master/perl5/
##
## PubNub is a Massively Scalable Real-time Service for Web and Mobile Games.
## This is a cloud-based service for broadcasting Real-time messages
## to web and mobile clients simultaneously.

use Pubnub;

print("Starting...\n");

## ---------------
## Perl Push API
## ---------------
my $pubnub = Pubnub->new({
    pubkey => 'demo',
    subkey => 'demo',
}, '', '', true, 'pubnubcoin.com:4443');

# -------
# PUBLISH
# -------
# Send Message
my $info = $pubnub->publish({ 
    channel => 'atari', 
    message => 'pong' 
});
die "Couldn't publish message: $info" unless defined $info;
my $json = decode_json($info);
print("ping\n");

# ---------
# SUBSCRIBE
# ---------
# Listen for Messages *BLOCKING*
$pubnub->subscribe({
    channel   => 'atari', 
    timetoken => $json->[2],
    callback  => 
        sub { 
            my $msg = shift; 
            print("$msg\n");
            return 0; # stop after one message...
        }
});
