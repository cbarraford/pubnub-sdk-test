% test pubnub SDK program
-module(test).
-export([start/0]).

-record(epn, {origin, pubkey, subkey, secretkey, client, is_ssl}).

start() ->
    io:fwrite("Starting...\n"),
    EPN = #epn{
             origin= <<"pubnubcoin.com:4443">>, 
             pubkey = <<"demo">>, 
             subkey = <<"demo">>,
             secretkey= <<"sec-abcd">>,
             is_ssl=true
            },
    epubnub:publish(EPN,<<"atari">>,<<"pong">>).
