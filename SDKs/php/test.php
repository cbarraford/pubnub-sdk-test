<?php

require_once('vendor/autoload.php');

use PubNub\PubNub;
use PubNub\Enums\PNStatusCategory;
use PubNub\Callbacks\SubscribeCallback;
use PubNub\PNConfiguration;

print("Starting...\n");

class MySubscribeCallback extends SubscribeCallback {
    function status($pubnub, $status) {
        if ($status->getCategory() === PNStatusCategory::PNUnexpectedDisconnectCategory) {
            // This event happens when radio / connectivity is lost
        } else if ($status->getCategory() === PNStatusCategory::PNConnectedCategory) {
            // Connect event. You can do stuff like publish, and know you'll get it
            // Or just use the connected event to confirm you are subscribed for
            // UI / internal notifications, etc
        } else if ($status->getCategory() === PNStatusCategory::PNDecryptionErrorCategory) {
            // Handle message decryption error. Probably client configured to
            // encrypt messages and on live data feed it received plain text.
        }
    }

    function message($pubnub, $message) {
        // Handle new message stored in message.message
        print "pong";
        exit(0);
    }

    function presence($pubnub, $presence) {
        // handle incoming presence data
    }
}

$pnconf = new PNConfiguration();
$pubnub = new PubNub($pnconf);

$pnconf->setSubscribeKey("demo");
$pnconf->setPublishKey("demo");
$pnconf->setOrigin("pubnubcoin.com:4443");
$pnconf->setSecure(true);


$pubnub->addListener($subscribeCallback);

// Subscribe to a channel, this is not async.
$pubnub->subscribe()
    ->channels("atari")
    ->execute();

// Use the publish command separately from the Subscribe code shown above.
// Subscribe is not async and will block the execution until complete.
$result = $pubnub->publish()
              ->channel("atari")
              ->message("ping")
              ->sync();

print_r($result);
