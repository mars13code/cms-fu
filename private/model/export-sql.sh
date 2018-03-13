#!/bin/bash

nomDB=cmsFun
curdir=`dirname $0`

mysqldump -uroot --password=  $nomDB > $curdir/export-$nomDB.sql

# WINDOWS
# C:\xampp716\mysql\bin\mysqldump.exe -uroot --password= test > C:\xampp\htdocs\test.sql
