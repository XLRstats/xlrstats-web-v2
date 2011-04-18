# 18/04/2011 - v1.1 - xlr8or
#  * Rewrite code to support unicode

__version__ = '1.1'
__author__  = 'Anubis'

import b3, threading
import b3.events
import b3.plugin
import time
from b3 import clients
import datetime
import b3.cron

class TimeStats:
    came = None
    left = None 
    client = None

#--------------------------------------------------------------------------------------------------
class CtimePlugin(b3.plugin.Plugin):
    _clients = {} 
    _cronTab = None
    _max_age_in_days = 31
    _hours = 5
    _minutes = 0

    def onStartup(self):
        self.registerEvent(b3.events.EVT_CLIENT_AUTH)
        self.registerEvent(b3.events.EVT_CLIENT_DISCONNECT)
        self.query = self.console.storage.query
        tzName = self.console.config.get('b3', 'time_zone').upper()
        tzOffest = b3.timezones.timezones[tzName]
        hoursGMT = (self._hours - tzOffest)%24
        self.debug(u'%02d:%02d %s => %02d:%02d UTC' % (self._hours, self._minutes, tzName, hoursGMT, self._minutes))
        self.info(u'everyday at %2d:%2d %s, connection info older than %s days will be deleted' % (self._hours, self._minutes, tzName, self._max_age_in_days))
        self._cronTab = b3.cron.PluginCronTab(self, self.purge, 0, self._minutes, hoursGMT, '*', '*', '*')
        self.console.cron + self._cronTab

    #def onLoadConfig(self):
        #self._welcomeFlags = self.config.getint('settings', 'flags')
        #self._newbConnections = self.config.getint('settings', 'newb_connections')

    def purge(self):
        if not self._max_age_in_days or self._max_age_in_days == 0:
            self.warning(u'max_age is invalid [%s]' % self._max_age_in_days)
            return False

        self.info(u'purge of connection info older than %s days ...' % self._max_age_in_days)
        q = "DELETE FROM ctime WHERE came < %i" % (self.console.time() - (self._max_age_in_days*24*60*60))
        self.debug(u'CTIME QUERY: %s ' % q)
        cursor = self.console.storage.query(q)
    
    def onEvent(self, event):
        if event.type == b3.events.EVT_CLIENT_AUTH:
            if  not event.client or \
                not event.client.id or \
                event.client.cid == None or \
                not event.client.connected or \
                event.client.pbid == 'WORLD' or \
                event.client.pbid == 'Server':
                return
            
            self.update_time_stats_connected(event.client)
            
        elif event.type == b3.events.EVT_CLIENT_DISCONNECT:
            self.update_time_stats_exit(event.data)

    def update_time_stats_connected(self, client):
        if (self._clients.has_key(client.cid)):
            self.debug(u'CTIME CONNECTED: Client exist! : %s' % client.cid);
            tmpts = self._clients[client.cid]
            if(tmpts.client.guid == client.guid):
                self.debug(u'CTIME RECONNECTED: Player %s connected again, but playing since: %s' %  (client.exactName, tmpts.came))
                return
            else:
                del self._clients[client.cid]
        
        ts = TimeStats()
        ts.client = client
        ts.came = datetime.datetime.now()
        self._clients[client.cid] = ts
        self.debug(u'CTIME CONNECTED: Player %s started playing at: %s' % (client.exactName, ts.came))

    def formatTD(self, td):
        hours = td // 3600
        minutes = (td % 3600) // 60
        seconds = td % 60
        return '%s:%s:%s' % (hours, minutes, seconds) 
  
    def update_time_stats_exit(self, clientid):
        self.debug(u'CTIME LEFT:')
        if (self._clients.has_key(clientid)):
            ts = self._clients[clientid]
            # Fail: Sometimes PB in cod4 returns 31 character guids, we need to dump them. Lets look ahead and do this for the whole codseries.
            #if(self.console.gameName[:3] == 'cod' and self.console.PunkBuster and len(ts.client.guid) != 32):
            #    pass
            #else:
            ts.left = datetime.datetime.now()
            diff = (int(time.mktime(ts.left.timetuple())) - int(time.mktime(ts.came.timetuple())))

            self.debug(u'CTIME LEFT: Player: %s played this time: %s sec' % (ts.client.exactName, diff))
            self.debug(u'CTIME LEFT: Player: %s played this time: %s' % (ts.client.exactName, self.formatTD(diff)))
            #INSERT INTO `ctime` (`guid`, `came`, `left`) VALUES ("6fcc4f6d9d8eb8d8457fd72d38bb1ed2", 1198187868, 1226081506)
            q = 'INSERT INTO ctime (guid, came, gone, nick) VALUES (\"%s\", \"%s\", \"%s\", \"%s\")' % (ts.client.guid, int(time.mktime(ts.came.timetuple())), int(time.mktime(ts.left.timetuple())), ts.client.name)
            self.query(q)
                
            self._clients[clientid].left = None
            self._clients[clientid].came = None
            self._clients[clientid].client = None
                
            del self._clients[clientid]
           
        else:
            self.debug(u'CTIME LEFT: Player %s var not set!' % clientid)
