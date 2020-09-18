#!/bin/sh

if [ "$1" = "travis" ]; then
    psql -U postgres -c "CREATE DATABASE ytdownloader_test;"
    psql -U postgres -c "CREATE USER ytdownloader PASSWORD 'ytdownloader' SUPERUSER;"
else
    sudo -u postgres dropdb --if-exists ytdownloader
    sudo -u postgres dropdb --if-exists ytdownloader_test
    sudo -u postgres dropuser --if-exists ytdownloader
    sudo -u postgres psql -c "CREATE USER ytdownloader PASSWORD 'ytdownloader' SUPERUSER;"
    sudo -u postgres createdb -O ytdownloader ytdownloader
    sudo -u postgres psql -d ytdownloader -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    sudo -u postgres createdb -O ytdownloader ytdownloader_test
    sudo -u postgres psql -d ytdownloader_test -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    LINE="localhost:5432:*:ytdownloader:ytdownloader"
    FILE=~/.pgpass
    if [ ! -f $FILE ]; then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE; then
        echo "$LINE" >> $FILE
    fi
fi
