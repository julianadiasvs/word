#!/usr/bin/env bash

unameOut="$(uname -s)"
case "${unameOut}" in
    Linux*)     machine=Linux;;
    Darwin*)    machine=Mac;;
    CYGWIN*)    machine=Cygwin;;
    MINGW*)     machine=MinGw;;
    *)          machine="UNKNOWN:${unameOut}"
esac

printf "\e[1;32mRunning Start script for ${machine} OS...\e[0m\n\n";

BASEDIR=$(dirname "$0")
cd $BASEDIR/../../

if [ "$machine" == "Linux" ]; then
    # sudo ip addr add 10.254.254.254/24 brd + dev lo label lo:1
    sudo docker-compose -f docker-compose.yml up -d;
    sudo docker-compose -f docker-compose.yml start;
fi

if [ "$machine" == "Mac" ]; then
    sudo ifconfig en1 alias 10.254.254.254 255.255.255.0
#    docker-sync start;
    docker-compose -f docker-compose.yml -f docker-compose-mac.yml up --no-start;
    docker-compose -f docker-compose.yml -f docker-compose-mac.yml start;
fi
