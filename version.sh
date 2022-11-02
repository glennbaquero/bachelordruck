#!/bin/bash

VERSION=$(cat config/app.php \
| grep version \
| head -1 \
| awk -F "=>" '{ print $2 }' \
| sed "s/[',]//g" \
| tr -d '[[:space:]]'
)

echo "bash bump.sh $VERSION" > /dev/clipboard
