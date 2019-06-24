#!/bin/sh
set -eo pipefail

#Mail
echo "Start Postfix"
HOST=`hostname -f`
echo "myhostname = $HOST" >> /etc/postfix/main.cf && \
echo "mynetworks = 127.0.0.0/8 [::ffff:127.0.0.0]/104 [::1]/128" >> /etc/postfix/main.cf && \
echo "inet_interfaces = all" >> /etc/postfix/main.cf
chmod 2770 /var/log
rsyslogd
postfix start

#Install App
install() {
    echo "Install Complete"
}

#Update App
update() {
    echo "Update Complete"
}

echo "Start App Init"

echo "Finish App Init"