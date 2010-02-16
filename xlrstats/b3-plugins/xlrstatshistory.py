##################################################################
#
# XLRstatshistory
# history addon for xlrstats for B3 (www.bigbrotherbot.com)
# (c) 2009 Mark Weirath (xlr8or@xlr8or.com)
#
# This program is free software and licensed under the terms of
# the GNU General Public License (GPL), version 2.
#
##################################################################
# CHANGELOG

__author__  = 'xlr8or'
__version__ = '1.0.0'

# Version = major.minor.patches

import string, time, re, thread

import b3
import b3.events
import b3.plugin
import b3.cron
import b3.timezones

#--------------------------------------------------------------------------------------------------
class XlrstatshistoryPlugin(b3.plugin.Plugin):
    requiresConfigFile = False

    _cronTabWeek = None
    _cronTabMonth = None
    # names for various stats tables
    playerstats_table = None
    history_monthly_table = 'xlr_history_monthly'
    history_weekly_table = 'xlr_history_weekly'
    

    def startup(self):

        # get the admin plugin so we can register commands
        self._adminPlugin = self.console.getPlugin('admin')
        if not self._adminPlugin:
            # something is wrong, can't start without admin plugin
            self.error('Could not find admin plugin')
            return False

        # get the xlrstats plugin
        self._xlrstatsPlugin = self.console.getPlugin('xlrstats')
        if not self._xlrstatsPlugin:
            # something is wrong, can't start without xlrstats plugin
            self.error('Could not find xlrstats plugin')
            return False
        else:
            self.verbose('Found XLRstats plugin, continueing...')
            try:
                self.playerstats_table = self._xlrstatsPlugin.playerstats_table
                self.verbose('Found XLRstats playerstats_table: %s' %self.playerstats_table)
            except:
                self.critical('Xlrstats Playerstats table not found!')

        try:
            # register our commands
            if 'commands' in self.config.sections():
                for cmd in self.config.options('commands'):
                    level = self.config.get('commands', cmd)
                    sp = cmd.split('-')
                    alias = None
                    if len(sp) == 2:
                        cmd, alias = sp
    
                    func = self.getCmd(cmd)
                    if func:
                        self._adminPlugin.registerCommand(self, cmd, level, func, alias)
        except:
            self.verbose('No configfile/commands found!')

        #define a shortcut to the storage.query function
        self.query = self.console.storage.query

        # remove existing crontabs
        if self._cronTabMonth:
            self.console.cron - self._cronTabMonth
        if self._cronTabWeek:
            self.console.cron - self._cronTabWeek

        # install crontabs
        self._cronTabMonth = b3.cron.PluginCronTab(self, self.snapshot_month, 0, 0, 0, 1, '*', '*')
        self.console.cron + self._cronTabMonth
        self._cronTabWeek = b3.cron.PluginCronTab(self, self.snapshot_week, 0, 0, 0, '*', '*', 1) # day 1 is monday
        self.console.cron + self._cronTabWeek

        # test sql
        #self.snapshot_month()
        #self.snapshot_week()
        
    def onLoadConfig(self):
        try:
            self.history_monthly_table = self.config.get('tables', 'history_monthly')    
        except:
            self.history_monthly_table = 'xlr_history_monthly'
            self.debug('Using default value (%i) for tables::history_monthly', self.history_monthly_table)
        try:
            self.history_weekly_table = self.config.get('tables', 'history_weekly')    
        except:
            self.history_weekly_table = 'xlr_history_weekly'
            self.debug('Using default value (%i) for tables::history_weekly', self.history_weekly_table)



    def snapshot_month(self):
        sql = ('INSERT INTO ' + self.history_monthly_table + ' (`client_id` , `kills` , `deaths` , `teamkills` , `teamdeaths` , `suicides` ' +
            ', `ratio` , `skill` , `winstreak` , `losestreak` , `rounds`, `year`, `month`, `week`, `day`)' +
            '  SELECT `client_id` , `kills`, `deaths` , `teamkills` , `teamdeaths` , `suicides` , `ratio` , `skill` , `winstreak` ' +
            ', `losestreak` , `rounds`, YEAR(NOW()), MONTH(NOW()), WEEK(NOW(),3), DAY(NOW())' + 
            '  FROM `' + self.playerstats_table + '`' )
        try:
            self.query(sql)
            self.verbose('Monthly XLRstats snapshot created')
        except Exception, msg:
            self.error('Creating history snapshot failed: %s' %msg)
   
    def snapshot_week(self):
        sql = ('INSERT INTO ' + self.history_weekly_table + ' (`client_id` , `kills` , `deaths` , `teamkills` , `teamdeaths` , `suicides` ' +
            ', `ratio` , `skill` , `winstreak` , `losestreak` , `rounds`, `year`, `month`, `week`, `day`)' +
            '  SELECT `client_id` , `kills`, `deaths` , `teamkills` , `teamdeaths` , `suicides` , `ratio` , `skill` , `winstreak` ' +
            ', `losestreak` , `rounds`, YEAR(NOW()), MONTH(NOW()), WEEK(NOW(),3), DAY(NOW())' + 
            '  FROM `' + self.playerstats_table + '`' )
        try:
            self.query(sql)
            self.verbose('Weekly XLRstats snapshot created')
        except Exception, msg:
            self.error('Creating history snapshot failed: %s' %msg)



"""\
Crontab:
*  *  *  *  *  command to be executed
-  -  -  -  -
|  |  |  |  |
|  |  |  |  +----- day of week (0 - 6) (Sunday=0)
|  |  |  +------- month (1 - 12)
|  |  +--------- day of month (1 - 31)
|  +----------- hour (0 - 23)
+------------- min (0 - 59)

Query:
INSERT INTO xlr_history_weekly (`client_id` , `kills` , `deaths` , `teamkills` , `teamdeaths` , `suicides` , `ratio` , `skill` , `winstreak` , `losestreak` , `rounds`, `year`, `month`, `week`, `day`) 
  SELECT `client_id` , `kills` , `deaths` , `teamkills` , `teamdeaths` , `suicides` , `ratio` , `skill` , `winstreak` , `losestreak` , `rounds`, YEAR(NOW()), MONTH(NOW()), WEEK(NOW(),3), DAY(NOW()) 
  FROM `xlr_playerstats`
"""
