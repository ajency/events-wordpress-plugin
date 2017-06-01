#!/bin/sh
for file in */*.tar.gz; do
    (cd `dirname $file`; tar xvf `basename $file`)
done