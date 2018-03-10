#!bin/sh

curdate=`date +"%F-%T"`

git status

git add -A

git commit -a -m "$curdate"

git push