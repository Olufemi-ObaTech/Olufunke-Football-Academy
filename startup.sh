#!/bin/bash
sed -i 's/\/home\/site\/wwwroot/\/home\/site\/wwwroot\/public/g' /etc/apache2/sites-enabled/000-default.conf
service apache2 restart
