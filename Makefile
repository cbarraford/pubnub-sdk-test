.PHONY: setup setup-submodules run run-all check-http2 check-sdk sh rebuild down

# setup your environment
setup: setup-submodules

# isntall git submodules
setup-submodules:
	@echo "Installing git submodules"
	@git submodule update --init --recursive

# rebuild docker image (if env var specifies)
rebuild:
	@if test "$(REBUILD)" = "true" ; then \
        echo "Forcing rebuild of SDK docker image..."; \
		docker rmi pubnub-${SDK} || echo "No image to delete"; \
    fi

# stop docker compose containers
down:
	@docker-compose down --remove-orphans

# get into an interactive shell
sh: check-sdk check-http2 rebuild down
	@SDK=${SDK} docker-compose run --rm pubnub /bin/sh

# run test for a specific SDK
run: check-sdk check-http2 rebuild down
	@SDK=${SDK} docker-compose run --rm pubnub

# run tests for all SDKs
run-all: check-http2
	@set -e
	@for dir in ./SDKs/* ; do \
		SDK=$$(echo $$dir | awk -F "/" '{print $$NF}'); \
		echo "Testing SDK: $$SDK"; \
		SDK=$$SDK $(MAKE) run || exit $$?; \
	done

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
