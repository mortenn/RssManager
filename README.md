RssManager
==========

Simple web frontend for managing RSS feeds in conjuction with transmission

Installation
============

Go to the desired location for the files on your server and clone this repository.
```shell
git clone https://github.com/mortenn/RssManager.git
cd RssManager
git submodule init
git submodule update
```

Next, you need to copy config.default.php to config.php and edit it to input your own details.
If you are going to work off of nyaa, you should only need to modify the database connection details and the TARGET.

If you want error reports from the site, set $alertmail to your email address.

TARGET is the destination folder where transmission should save your downloads.
autoadd is wether or not the cron job should add torrents to transmission automatically.

For the RSS scraping to happen, you will need to set up a crontab to run the poll.php script.
I suggest setting up your crontab something like this;
```crontab
*/20 * * * * /path/to/RssManager/poll.php
```

If you have VLC installed, the play button will let you open the downloaded files either in your browser or in a new VLC window.
The $embed configuration option controls this behaviour.
$share should point to the correct path for your desktop to access the files. If you run everything on your desktop, this can be the same as TARGET.

Lastly, you need to serve up the www folder using a web server with PHP support.
