
.PHONY: setup run run-all check-http2 check-sdk 

LOWER_SDK = $(shell echo $(SDK) | tr A-Z a-z)

setup:
	@echo "Installing git submodules"
	@git submodule update --init --recursive

run: check-sdk check-http2
	@if test "$(REBUILD)" = "true" ; then \
        echo "Forcing rebuild of SDK docker image..."; \
		docker rmi pubnub-${LOWER_SDK}; \
    fi
	@docker-compose down --remove-orphans
	@SDK=${SDK} LOWER_SDK=${LOWER_SDK} docker-compose run --rm pubnub

run-all: check-http2
	@echo "Not Implemented"
	@exit 1

# This ensures http2 is downloaded, fixes it if not.
check-http2:
ifeq (,$(wildcard ./http2/dockerfile))
	@echo "http2 is missing, resolving..."
	@$(MAKE) setup
endif

# This ensures environment has the env var SDK
check-sdk:
	@if test "$(SDK)" = "" ; then \
        echo "You must pass the env var SDK to this make command"; \
        exit 1; \
    fi
