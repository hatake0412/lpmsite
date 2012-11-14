#!/bin/tcsh

cp ../lpm ~/www.kasahara.ws/lpm
cp ../lpm .
./sign.sh lpm
cp ./lpm.asc ~/www.kasahara.ws/lpm/repository/

# hg update
# cp *.lpm *.asc ~/www.kasahara.ws/lpm/repository/
