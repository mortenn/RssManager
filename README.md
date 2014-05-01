RssManager
==========

Simple web frontend for managing RSS feeds in conjuction with transmission

Installation
============

Go to the desired location for the files on your server and clone this repository.
```shell
git clone https://github.com/mortenn/RssManager.git
git submodule init
git submodule update
```

Next, you need to copy config.default.php to config.php and edit it to input your own details.
If you are going to work off of nyaa, you should only need to modify the database connection details and the TARGET.

TARGET is the destination folder where transmission should save your downloads.
autoadd is wether or not the cron job should add torrents to transmission automatically.

Lastly, you need to serve up the page using a web server with PHP support.
