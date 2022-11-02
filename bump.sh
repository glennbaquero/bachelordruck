#!/bin/bash

function help {
    echo "Usage: $(basename $0) <newversion>"
}

if [ -z "$1" ] || [ "$1" = "help" ]; then
    help
    exit
fi

message=$2

if [ -z "$2" ]; then
    message="Bump"
fi

version=$1

sed -r -i "/version/ s/(^.*)(=.*)/\1=> '$version',/g" config/app.php
git add config/app.php
git commit -m "$message version to $version"
