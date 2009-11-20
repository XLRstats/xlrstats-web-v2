###################################################################################
#
# Plugin for B3 (www.bigbrotherbot.com)
#
# This program is free software and licensed under the terms of
# the GNU General Public License (GPL), version 2.
#
# http://www.gnu.org/copyleft/gpl.html
#
###################################################################################

Ctime plugin for B3 by Anubis (www.g4g.pl)
###################################################################################
This plugin keeps track of playeractivity for the XLRstats webfront.

Requirements:
###################################################################################

- B3 version 1.1.0 or higher


Installation:
###################################################################################

1. Unzip the contents of this package into your B3 folder. It will
place the .py file in b3/extplugins and the config file .xml in
your b3/extplugins/conf folder.

2. Create the ctime table in your database importing the ctime.sql file.

3. Open your B3.xml file (in b3/conf) and add the next line in the
<plugins> section of the file:

<plugin name="ctime" priority="12" config="@b3/extplugins/conf/plugin_ctime.xml"/>

The numer 12 in this just an example. Make sure it fits your
plugin list.
