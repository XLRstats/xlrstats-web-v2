################################################################################
#
# XLRstats Webfront
# Webfront for XLRstats stats plugin for B3 (www.bigbrotherbot.com)
# (c) 2004-2010 www.xlr8or.com (mailto:xlr8or@xlr8or.com)
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Library General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
#
# http://www.gnu.org/copyleft/gpl.html
################################################################################

XLRstats webfront (v.2.x.x) for B3
################################################################################

Make your XLRstats public!


################################################################################
Requirements:
################################################################################

- Working version of B3 with XLRstats plugin functioning correctly
- Website running php.
- website must have access to your B3 database.

- B3 plugin status.py version 1.2.5 or higher! (included in this package)
- Installed B3 plugin ctime.py (included in this package)
  (See directory b3-plugins in this package)


################################################################################
Automatic Single and Multi Server Installation (Using the installer): 
################################################################################

1. Extract this package in your website!. Default folder is xlrstats, but you
can rename it to whatever you like.

2. XLRstats comes with imagepacks for different games. Pick the appropriate 
package and extract that into your xlrstats directory. 

3. Point your browser to xlrstats and follow the instructions.


################################################################################
Manual Single Server Installation:
################################################################################

1. Extract this package in your website!. Default folder is xlrstats, but you
can rename it to whatever you like.

2. XLRstats comes with imagepacks for different games. Pick the appropriate 
package and extract that into your xlrstats directory. 

3. Make the directory ./dynamic and its contents writable by the webserver, 
XLRstats will place its dynamic files there. (linux users: chmod 777).

4. Copy/rename the file ./config/distro-config.php to 
./config/statsconfig.php and edit it to fit your server settings.

5. Modify the statsconfig.php file with your favorite texteditor 

6. Rename/remove the ./install directory to prevent direct access!


################################################################################
Manual Multi Server Installation:
################################################################################

- XLRstats v2 is able to handle multiple gameservers from one install. How to 
enable it without going thru setup again? It's fairly simple. 

1. First install XLRstats as described above. Make sure you test it all before 
continueing.

2. If all is well, rename ./config/statsconfig.php to ./config/statsconfig1.php
and copy it to statsconfig2.php

3. Modify statsconfig2.php with an editor to fit your second server.

4. You can continue adding configs untill you run out of servers ;)

5. Visit http://path.to.xlrstats/config/install_award_idents.php to create
award files for each server! You can repeat this later when you find not all
weapons have been used ingame yet. When you get empty awards this is usually
the case (or ofcourse it indicates that no kills where made with the weapon yet).
You should revisit the page every time you add a new server or change the order.

- Direct access to the different servers is available by linking to:
http://path.to.xlrstats/index.php?config=2 (replace the 2 with whatever 
confignumber/server you want to link to)


################################################################################
Things you NEED to know:
################################################################################

- In the sql directory there are 2 files for creation of the databasetables for
XLRstats (the plugin). The plugin needs them installed to store the statistics.
If you don't have them installed yet, run the sql files on the B3 database (or 
use a program like phpMyAdmin to run the sql queries)

- In the XLRstats database table 'xlr_playerstats' there is a field called
'hide'. This field set to one prevents a user being displayed on the website.
Especially usefull for 'WORLD' and BOTS :)

- In the same table there is a field called 'fixed_name'. This field can be
used to override a playername in the webstats.

Both fields have to be modified using a mysql directly, a webinterface like 
phpmyadmin or a GUI like navicat.

- XLRstats comes with imagepacks for different games. Pick the appropriate 
package and extract that into your xlrstats directory. 

-  If you intend to use the GeoIP data in the playerlist you'll have to download  
the (free) GeoIP.dat file from www.maxmind.com. Make sure the path to the file
is set correctly in your statsconfig file! 
(http://geolite.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz
this is a gzipped file, you need to unzip it with an unzipper like 7-zip 
before usage.)
NOTE 1: Add a trailing slash to the path: /path/to/GeoIP/
NOTE 2: Windows users: Use forward slashes in the path: C:/path/to/your/GeoIP/ 

- If you also want to use the worldmap you'll have to download the (free)
GeoLiteCity.dat file from www.maxmind.com. Make sure the path to the file
is set correctly in your statsconfig file! (See 7. they both use the same path).
If you don't want the worldmap, simply delete (or rename) the 
GeoLiteCity.dat file.
(http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz this is
a gzipped file, you need to unzip it with an unzipper like 7-zip before usage.)

- You can have game specific medals. At the moment these are not available, but
you can make your own. Create a folder with your game abbreviation in 
./images/medals/, i.e. ./images/medals/urt/ and put the medals there. XLRstats
will automatically detect if the folder is available and use images from  that
folder. You must put all images in that folder if it is available on the 
webserver. (abbreviations: cod1, coduo, cod2, cod4, codwaw, urt, wop) 


################################################################################
Using the RSS feed
################################################################################

The RSS feed was designed to present a topplayers list to publish on websites
with RSS feed possibilities or Feedreaders. So you can check or publish your
toplists using the RSS 2.0 technology. To select a feed simply choose a toplist
and click the little RSS button in the footer, or copy it's link location. Enter
this link location in your favorite RSS reader or copy it to the RSS feed module
in your website. Many CMS's support RSS Feeds or have modules available for 
installation.

Another way to include toplists in websites is by using php inclusionfiles like
the example block.php. You need proper knowledge of php and specific webserver
settings to use this. This is an example and if you don't understand what it 
does, don't ask, it is not supported.

 
################################################################################
Using sigs
################################################################################

Ths sig generator is multiserver aware. Sigs are to be used by your players to 
advertise your server on different websites. 
It requires php version 4.3.2 or higher and the PHP GD2 extension installed on
the webserver. Some hosting companies may not suppor this, and the sig generator 
will not work in those cases.

Sigs will not be available if min_kills or min_rounds is not met, if the player
has not played for max_days. It will generate a message in the sig why there
is no info available (yet).


################################################################################
Contributors
################################################################################

* Many code for the website was contributed by Anubis from www.g4g.pl. Also some
  of the medals originate from their communitymember 'Hellwi'. Thanks guys!
* Web2 popups and mySQL voodoo provided by Courgette
* The ratio-bar variations, medal top players pages and some templates where 
  made by Freelander[*] 
  of the xlr8or community (cod2, cod4a cod5, pardus, urt1, urt2, urt3, urt4)  
################################################################################
xlr8or - 4 april 2009 - www.bigbrotherbot.com // www.xlr8or.com
