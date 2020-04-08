#!/usr/bin/env bash

BASEDIR=$(dirname "$0")

# Restore mysql database to docker container
docker exec -i word_db_1 mysql -pwppass -uwpuser wpdb < $BASEDIR/../data/wpdb.sql.dump

echo "Database restored!"
