# rss

Read, store and search RSS.


## Summary

1. Read RSS (RSS1.0) every 5 minutes using Cron, and store it in the database (MySQL)
    * URL format: http://(user name).abcd(server no).test.com/efgh(entry no).html
    * Delete the data 3 days ago

2. Search the RSS data on web page
    * Criteria: date, URL, user name, server no, entry no, title
    * Display: date, URL, title, description
    * Have pager function
    * Stored criteria in cookie for next visit
    * Separate PHP from HTML without template and framework


## Implementation

1. Create Table on Database
    1. Connect to MySql
    2. Command create table and columns:
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
    1. Connect to server
    2. Check login information in class/database.php
    3. Upload all folders and files to '/home/xxx/public_html'

3. Set Cron
    1. Connect to server
    2. Set Cron
        1. Command 'crontab -e'
        2. Hit 'esc' key to change to edit mode
        3. Hit 'i' key to change to insert mode
        4. Command '*/5 * * * * /usr/bin/php /home/xxx/public_html/rssUpdate.php'
        5. Hit 'esc' key to return to edit mode
        6. Command ':w' to save
        7. Command ':q' to exit
        8. Command 'crontab -l' to confirm cron setting
