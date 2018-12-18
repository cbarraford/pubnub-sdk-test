# pubnub-sdk-test
This repo was created to test the many SDKs supported by Pubnub.com in an
automated way.

## Test a specific SDK

In the `./SDKs` directory, are all the SDKs that are currently supported. To
test a specific SDK (like NodeJS for example), run the following...

```sh
make run SDK=NodeJS
```

If you want to force a rebuild of the docker image, include `REBUILD=true` in
your `make command`.

## TODO
 * [ ] -
   [Javascript](https://www.pubnub.com/docs/web-javascript/pubnub-javascript-sdk)
 * [ ] -
   [Objective-C](https://www.pubnub.com/docs/ios-objective-c/pubnub-objective-c-sdk)
 * [ ] - [Android](https://www.pubnub.com/docs/android-java/pubnub-java-sdk)
 * [ ] - [Chat
   Engine](https://www.pubnub.com/docs/chat-engine/getting-started)
 * [ ] - [Swift](https://www.pubnub.com/docs/swift/pubnub-swift-sdk)
 * [ ] - [Java](https://www.pubnub.com/docs/java-se-java/pubnub-java-sdk)
 * [ ] -
   [NodeJS](https://www.pubnub.com/docs/nodejs-javascript/pubnub-javascript-sdk)
 * [ ] - [Posix C++](https://www.pubnub.com/docs/posix-cpp/pubnub-cpp-sdk)
 * [ ] - [AngularJS](https://www.pubnub.com/docs/angularjs-javascript/pubnub-javascript-sdk)
 * [ ] - [PHP](https://www.pubnub.com/docs/php/pubnub-php-sdk)
 * [ ] - [Python](https://www.pubnub.com/docs/python/pubnub-python-sdk)
 * [ ] - [Go](https://www.pubnub.com/docs/go/pubnub-go-sdk)
