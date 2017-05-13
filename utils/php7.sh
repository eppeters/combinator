#!/usr/bin/env bash
set -euo pipefail
IFS=$'\n\t'

#/ Usage: php7.sh ARGS...
#/ Description: Runs php on the source inside a container, using the provided args
#/ Examples: php7.sh vendor/bin/composer require phpunit/phpunit
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

docker_run_php7() {
    docker run --rm -v "$(pwd):/app" -w /app php:7.1.4-cli php "$@"
}

if [[ "${BASH_SOURCE[0]}" = "$0" ]]; then
    trap cleanup EXIT

    docker_run_php7 "$@"
fi
