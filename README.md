IP Mailer
========

Simple Python script that sends you an email when the IP of your machine changes.

It will grab your public ip using http://jsonip.com/, save it in a file and email you when the ip changes.
It must be running over a service like cron (Unix) or launchctl (Mac) and should be called every X minutes according to your needs.

As I'm not a Python expert, feel free to fork and improve this script.
