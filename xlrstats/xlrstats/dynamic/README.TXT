This directory (./dynamic) must be writable by the webserver.
Inhere it will write the identified award files and keep track of visitors.

The awardfiles are specific for each server since the weapons are saved in
the database differently for each server. The installation file in the config
directory (install_award_idents.php) will take care of that.

So on linux systems chmod this file to 777 or make the webserver the owner of 
the directory. This is essential for the awards and visitor counter.

xlr8or  
