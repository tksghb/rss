rss
===

Read, store and search RSS.



The Project
-----------

1. Read RSS (RSS1.0) every 5 minuts using cron, and store in the database (MySQL).
   URL format: http://(user name).abcd(server no).test.com/efgh(entry no).html

2. Create web page which can search the RSS data.



Implementation Procedure
------------------------

1. Create Table on Database
    A. Connect to MySql
    B. Command create table and columns
        CREATE TABLE Rss (
        RssID int NOT NULL AUTO_INCREMENT,
        Date datetime,
        Title varchar(1000),
        Description varchar(2000),
        Url varchar(1000),
        UserName varchar(255),
        ServerNo int,
        EntryNo int,
        CreateDate datetime,
        PRIMARY KEY (RssID)
        )

2. Upload Program
    A. Connect to server
    B. Check login information in class/database.php
    C. Upload all folders and files to '/home/xxx/public_html'

3. Set Cron
    A. Connect to server
    B. Set Cron
        a. Command 'crontab -e'
        b. Hit 'esc' key to change to edit mode
        c. Hit 'i' key to change to insert mode
        d. Command '*/5 * * * * /usr/bin/php /home/xxx/public_html/rssUpdate.php'
        e. Hit 'esc' key to return to edit mode
        f. Command ':w' to save
        g. Command ':q' to exit
        h. Command 'crontab -l' to confirm cron setting
