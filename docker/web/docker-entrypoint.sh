#!/bin/sh
set -eo pipefail

# start cron
/usr/sbin/crond
(crontab -l 2>/dev/null; echo "*       *       *       *       *       php /root/restart.php") | crontab - 

if [ -z ${APP_ENV+x} ] && [ "$APP_ENV" != "dev" ]; then
    #Update Hosts file to resolve local app
    echo "#App PHP-FPM" >> /etc/hosts
    echo "127.0.0.1 app" >> /etc/hosts
    #This is for the restart script
    echo "" >> /usr/local/apache2/conf/extra/app.conf
    echo "ErrorLog /var/log/apache2/error.log" >> /usr/local/apache2/conf/extra/app.conf
fi

COMMAND=${COMMAND:="httpd-foreground"}

${COMMAND}