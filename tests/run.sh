#!/usr/bin/env bash
# vim
set -euo pipefail
IFS=$'\n\t'

#/ Usage: run.sh OPTION
#/ Description: Runs tests, assuming pwd is source root
#/ Examples: run.sh --behavior
#/ Options:
#/   --help: Display this help message
#/   --behavior: Run behavior tests
#/   --unit: Run unit tests
#/   --all: Run all possible tests
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

if [[ ! $# -eq 1 ]]; then
    usage
fi

which_tests=''
while [[ $# -gt 0 ]]
do
    key="$1"

    # while/case/shift pattern from
    # http://stackoverflow.com/questions/192249/how-do-i-parse-command-line-arguments-in-bash/14203146#14203146
    case $key in
        -a|--all)
            which_tests='all'
            shift
            ;;
        -b|--behavior)
            which_tests='behavior'
            shift
            ;;
        -u|--unit)
            which_tests='unit'
            shift
            ;;
        *)
            fatal "Unknown option $key"
            ;;
    esac
done

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

DOCKER_PHPUNIT_TESTS_DIR="tests/phpunit"
DOCKER_DEV_NETWORK="combinator_dev"
DOCKER_COMBINATOR_DEV_INSTANCES="combinator-dev-webserver"
DOCKER_APP_DIR='/app'
DOCKER_ENV_VAR_FILE="$SCRIPT_DIR/../.env"

DOCKER_PHP_CONTAINER_IMAGE='php:7.1.4-alpine'
BEHAT_COMMAND='php vendor/bin/behat'
PHPUNIT_COMMAND="php vendor/bin/phpunit $DOCKER_PHPUNIT_TESTS_DIR"

docker_run_tests() {
    docker run --link "$DOCKER_COMBINATOR_DEV_INSTANCES" --network "$DOCKER_DEV_NETWORK" --env-file "$DOCKER_ENV_VAR_FILE" --rm -v "$(pwd):$DOCKER_APP_DIR" -w "$DOCKER_APP_DIR" "$DOCKER_PHP_CONTAINER_IMAGE" sh -c "$@"
}

if [[ "${BASH_SOURCE[0]}" = "$0" ]]; then
    trap cleanup EXIT

    case $which_tests in
        all)
            docker_run_tests "$BEHAT_COMMAND"
            docker_run_tests "$PHPUNIT_COMMAND"
        ;;
        behavior)
            docker_run_tests "$BEHAT_COMMAND"
        ;;
        unit)
            docker_run_tests "$PHPUNIT_COMMAND"
        ;;
        *)
            fatal "Unknown tests $which_tests. This is a problem with the script."
        ;;
    esac
fi
