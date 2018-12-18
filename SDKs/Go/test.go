package main

import (
	"fmt"

	pubnub "github.com/pubnub/go"
)

func main() {
	config := pubnub.NewConfig()
	config.Origin = "pubnubcoin.com:4443"
	config.SubscribeKey = "demo"
	config.PublishKey = "demo"

	pn := pubnub.NewPubNub(config)
	listener := pubnub.NewListener()
	doneConnect := make(chan bool)
	donePublish := make(chan bool)

	msg := map[string]interface{}{
		"msg": "hello",
	}
	go func() {
		for {
			select {
			case status := <-listener.Status:
				switch status.Category {
				case pubnub.PNDisconnectedCategory:
					// This event happens when radio / connectivity is lost
				case pubnub.PNConnectedCategory:
					// Connect event. You can do stuff like publish, and know you'll get it.
					// Or just use the connected event to confirm you are subscribed for
					// UI / internal notifications, etc
					doneConnect <- true
				case pubnub.PNReconnectedCategory:
					// Happens as part of our regular operation. This event happens when
					// radio / connectivity is lost, then regained.
				}
			case message := <-listener.Message:
				// Handle new message stored in message.message
				if message.Channel != "" {
					// Message has been received on channel group stored in
					// message.Channel
				} else {
					// Message has been received on channel stored in
					// message.Subscription
				}
				if msg, ok := message.Message.(map[string]interface{}); ok {
					fmt.Println(msg["msg"])
				}
				/*
				   log the following items with your favorite logger
				       - message.Message
				       - message.Subscription
				       - message.Timetoken
				*/

				donePublish <- true
			case <-listener.Presence:
				// handle presence
			}
		}
	}()

	pn.AddListener(listener)

	pn.Subscribe().
		Channels([]string{"hello_world"}).
		Execute()

	<-doneConnect

	response, status, err := pn.Publish().
		Channel("hello_world").Message(msg).Execute()

	if err != nil {
		fmt.Printf("Error: %s\n", err)
		return
	}

	fmt.Println(response, status, err)

	<-donePublish
}
