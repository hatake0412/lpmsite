#!/bin/sh

WWW_DIR=/home/htdocs/www.kasahara.ws/lpm
WWWREP_DIR=$WWW_DIR/repository

echo cd $WWWREP_DIR
cd $WWWREP_DIR
/home/mkasa/rep/lpm/wwwe/lpm/update_list en > $WWW_DIR/browse.html
/home/mkasa/rep/lpm/wwwe/lpm/update_list ja > $WWW_DIR/browse_ja.html

