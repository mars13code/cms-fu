#!/bin/bash

curdir=`dirname $0`

mysql -uroot --password=  < $curdir/database.sql

mysql -uroot --password=  < $curdir/data.sql

php $curdir/database.php

php $curdir/user.php

mysql -uroot --password=  < $curdir/user.sql

rm $curdir/user.sql
