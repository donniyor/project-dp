#!/bin/bash

if [[ $BITBUCKET_EXIT_CODE -gt 0 ]]
then
  curl -s -X POST https://api.telegram.org/bot1423950829:AAGMjz9k4HpLFCGUk6_o4IcKfz_98Z4d-4I/sendMessage -d chat_id=-1001441304307 -d text="[${BITBUCKET_BRANCH}] ${BITBUCKET_GIT_HTTP_ORIGIN}/pipelines/results/${BITBUCKET_BUILD_NUMBER} Deploy step [${1}] is FAILED "$'\U0001F4A9'""
else
  curl -s -X POST https://api.telegram.org/bot1423950829:AAGMjz9k4HpLFCGUk6_o4IcKfz_98Z4d-4I/sendMessage -d chat_id=-1001441304307 -d text="[${BITBUCKET_BRANCH}] ${BITBUCKET_GIT_HTTP_ORIGIN}/pipelines/results/${BITBUCKET_BUILD_NUMBER} Deploy step [${1}] is SUCCESS "$'\u2705'""
fi