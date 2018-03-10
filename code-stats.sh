#!/bin/bash

find . -name "*.php" -exec wc -l {} \; | sort -n

echo
echo "nombre de lignes de code PHP (unique)"

find . -name "*.php" -exec cat {} \; | sort -u | wc -l

echo
echo "nombre de lignes de code PHP:"

find . -name "*.php" -exec cat {} \; | wc -l
