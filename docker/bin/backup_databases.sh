#!/usr/bin/env bash

BASEDIR=$(dirname "$0")

# Restore mysql database to docker container
docker exec -i word_db_1 mysqldump --host=db --user=wpuser --password=wppass --default-character-set=utf8 wpdb > $BASEDIR/../data/wpdb.sql.dump

echo "Backup database is done!"

