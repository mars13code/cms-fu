#!bin/sh

curdate=`date +"%F-%T"`

curstatus=`git status --short`


git status 

git pull

git add -A

git commit -a -m "$curstatus"

git push