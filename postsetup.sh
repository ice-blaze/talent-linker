#!/usr/bin/env bash

# configure website depending on the current OS 

if [ "$(uname)" == "Darwin" ]; then
    php vendor/bin/homestead make
elif [ "$(expr substr $(uname -s) 1 5)" == "Linux" ]; then
    php vendor/bin/homestead make
elif [ "$(expr substr $(uname -s) 1 10)" == "MINGW32_NT" ]; then
    vendor\\bin\\homestead make
elif [ "$(expr substr $(uname -s) 1 10)" == "MINGW64_NT" ]; then
    vendor\\bin\\homestead make
fi
