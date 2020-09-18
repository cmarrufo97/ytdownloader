#!/bin/sh

BASE_DIR=$(dirname "$(readlink -f "$0")")
if [ "$1" != "test" ]; then
    psql -h localhost -U ytdownloader -d ytdownloader < $BASE_DIR/ytdownloader.sql
fi
psql -h localhost -U ytdownloader -d ytdownloader_test < $BASE_DIR/ytdownloader.sql
