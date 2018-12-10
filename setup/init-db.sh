#!/bin/bash

Prompt() {
    printf '%s [%s]: ' "$2" "$3"
    read value
    value="${value:=$3}"
    eval "$1='$value'"
}

PromptHidden() {
    printf '%s: ' "$2"
    read -s value
    echo
    value="${value:=}"
    eval "$1='$value'"
}

echo '# This script will initialize the app database.'
echo '# An account with admin privileges is required, but it will only be used for this script.'
echo

Prompt dbhost 'MySQL server host' 'localhost'

Prompt dbuser 'Database username' 'kanbans'
PromptHidden dbpass 'Database password'

Prompt dbname 'Database name' 'kanbans'

Prompt admuser 'MySQL admin username' 'root'
PromptHidden admpass 'MySQL admin password'


mysql -h "$dbhost" -u "$admuser" -p"$admpass" --vertical <<EOT

CREATE DATABASE IF NOT EXISTS $dbname;

CREATE USER IF NOT EXISTS '$dbuser'@'$dbhost'
    IDENTIFIED BY '$dbpass';

GRANT ALL PRIVILEGES
    ON $dbname.* TO '$dbuser'@'$dbhost';

EOT

if [ $? -eq 0 ]; then
    echo
    echo '# Database initialized successfully.'
    echo '# Make sure to regenerate your config file accordingly.'
else
    echo
    echo '# An error occured during the initialization.'
    echo '# See error above.'
fi
