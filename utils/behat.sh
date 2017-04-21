#!/usr/bin/env bash
set -euo pipefail
IFS=$'\n\t'

#/ Usage: behat.sh ARGS...
#/ Description: Runs behat on the source inside a container, using the provided args
#/ Examples: behat.sh --append-snippets
usage() { grep '^#/' "$0" | cut -c4- ; exit 0 ; }
expr "$*" : ".*--help" > /dev/null && usage

readonly LOG_FILE="/tmp/$(basename "$0").log"
info()    { echo "[INFO]    $@" | tee -a "$LOG_FILE" >&2 ; }
warning() { echo "[WARNING] $@" | tee -a "$LOG_FILE" >&2 ; }
error()   { echo "[ERROR]   $@" | tee -a "$LOG_FILE" >&2 ; }
fatal()   { echo "[FATAL]   $@" | tee -a "$LOG_FILE" >&2 ; exit 1 ; }

cleanup() {
    exit
}

PHP_CONTAINER_IMAGE='php:7.1.4-alpine'
docker_run_behat() {
    docker run --rm -v "$(pwd):/app" -w /app "$PHP_CONTAINER_IMAGE" vendor/bin/behat "$@"
}

if [[ "${BASH_SOURCE[0]}" = "$0" ]]; then
    trap cleanup EXIT

    docker_run_behat "$@"
fi
