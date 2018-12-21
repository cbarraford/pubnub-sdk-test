#!/bin/sh

set -e

erlc test.erl

exec "$@"
