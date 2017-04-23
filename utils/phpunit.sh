#!/usr/bin/env bash
set -euo pipefail
IFS=$'\n\t'

#/ Usage: phpunit.sh ARGS...
#/ Description: Runs phpunit on the source inside a container, using the provided args
#/ Examples: phpunit.sh --help
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

docker_run_phpunit() {
	docker run --rm -v "$(pwd):/app" phpunit/phpunit:6.0.6 "$@"
}

if [[ "${BASH_SOURCE[0]}" = "$0" ]]; then
    trap cleanup EXIT

    docker_run_phpunit "$@"
fi
