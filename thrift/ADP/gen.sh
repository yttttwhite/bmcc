#!/bin/bash

IN_PATH=.
OUT_JAVA=../java

#rm -f $OUT_JAVA/*.java

for file in `ls .`
do
    echo "gen code for $file"

    if [[ $file == *.thrift ]]
    then
        /usr/local/bin/thrift -out $OUT_JAVA -gen java $file
        echo "    gen from thrift"
    fi

    if [[ $file != *.proto && $file != *.thrift ]]
    then
        echo "    no need gen"
    fi
done

