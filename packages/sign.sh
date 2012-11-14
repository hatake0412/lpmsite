#!/bin/sh

gpg --homedir=../secretkey --clearsign $*
