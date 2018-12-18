
.PHONY: setup run

setup:
	@git submodule update --init --recursive

run: check-sdk
	@SDK=${SDK} docker-compose run --rm pubnub

check-sdk:
ifndef SDK
  $(error You must pass the env var SDK to this make command)
endif
