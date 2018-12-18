var PubNub = require('pubnub')
publish()

function publish() {

  pubnub = new PubNub({
    origin: 'pubnubcoin.com:4443',
    publishKey : 'demo',
    subscribeKey : 'demo'
  })

  function publishSampleMessage() {
    console.log("Since we're publishing on subscribe connectEvent, we're sure we'll receive the following publish.");
    var publishConfig = {
      channel : "atari",
      message: { 
        title: "ping",
        description: "pong"
      }
    }
    pubnub.publish(publishConfig, function(status, response) {
      console.log(status, response);
    })
  }

  pubnub.addListener({
    status: function(statusEvent) {
      if (statusEvent.category === "PNConnectedCategory") {
        publishSampleMessage();
      }
    },
    message: function(msg) {
      console.log(msg.message.title);
      console.log(msg.message.description);
      process.exit(0)
    },
    presence: function(presenceEvent) {
      // handle presence
    }
  })      
  console.log("Subscribing..");
  pubnub.subscribe({
    channels: ['atari'] 
  });
};
