#!/bin/sh -
#About: this script sends an email if your IP address change, it's supposed to run on cron

email="rafael@rafalopes.com.br"

function checkDependencies(){
    for i in $*; do
        type $i >/dev/null 2>&1 || { echo "$i dependency missing"; return 1; }
    done
}
function sendMail(){
    # TODO: Find a way to send autehticated mails via bash without 3rd party applications.
    echo -ne "Hello, my ip changed to: $1" |mail -s "IP Changed" $email
}
function checkIp(){
    jsonip=`curl jsonip.com -s |cut -d "\"" -f 4`
    [[ -f lastIp ]] || touch lastIp
    [[ `cat lastIp` == $jsonip ]] || sendMail $jsonip
    echo $jsonip > lastIp
}

checkDependencies curl mail
[ $? -ne 0 ] && { echo "Error: dependency missing. Aborting execution."; exit 1; }
checkIp $*