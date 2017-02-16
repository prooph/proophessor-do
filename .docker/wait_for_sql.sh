#!/bin/sh
set -e

echo ">> Waiting for MySql to start"
WAIT=0
while ! nc -z mysql 3306; do
  sleep 1
  echo "   MySql not ready yet"
  WAIT=$(($WAIT + 1))
  if [ "$WAIT" -gt 20 ]; then
    echo "Error: Timeout when waiting for MySql socket"
    exit 1
  fi
done

echo ">> MySql socket available, resuming command execution"

"$@"
