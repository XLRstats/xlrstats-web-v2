<?php
/***************************************************************************
 * Xlrstats Webmodule
 * Webfront for XLRstats for B3 (www.bigbrotherbot.com)
 * (c) 2004-2009 www.xlr8or.com (mailto:xlr8or@xlr8or.com)
 ***************************************************************************/

/***************************************************************************
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Library General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 *
 *  http://www.gnu.org/copyleft/gpl.html
 ***************************************************************************/
    global $currentconfignumber;
 
    echo "<a href=\"http://$mysiteurl\"  class = \"breadcrumb-a\">$mysitelinkname</a><span class=\"breadcrumb-a\"> : </span>";
    
    if($_SERVER['PHP_SELF'] == GetFileDir($_SERVER['PHP_SELF']) . "index.php")
    {
        echo "<a href=\"" . $link . "\" class = \"breadcrumb-a\">XLRStats</a><span class=\"breadcrumb-a\"> : </span>";
        //echo "<a href=\"http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "\" class = \"breadcrumb-a\">XLRStats</a><span class=\"breadcrumb-a\"> : </span>";
    }
    elseif ($_SERVER['PHP_SELF'] == GetFileDir($_SERVER['PHP_SELF']) . "build.php")
    {
        echo "<a href=\"" . $link . "\" class = \"breadcrumb-a\">XLRStats</a><span class=\"breadcrumb-a\"> : </span><a href=\"" . baselink() . "\" class = \"breadcrumb-a\">Signature Builder</a><span class=\"breadcrumb-a\"> : </span>";
        //echo "<a href=\"http://" . $_SERVER['HTTP_HOST'] . GetFileDir($_SERVER['PHP_SELF']) . "\" class = \"breadcrumb-a\">XLRStats</a><span class=\"breadcrumb-a\"> : </span><a href=\"http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "\" class = \"breadcrumb-a\">Signature Builder</a><span class=\"breadcrumb-a\"> : </span>";
    }

    if (isset($myplayerid))
      echo "<a href=\"$link?func=player&playerid=$myplayerid&config=${currentconfignumber}\" class = \"breadcrumb-a\">MyStats</a><span class=\"breadcrumb-a\"> : </span>";
    echo "<a class = \"breadcrumb-b\">$statstitle</a>";
    //echo $xlrstats_url;
    //echo $_SERVER['PHP_SELF'];
    //echo $_SERVER['HTTP_HOST'];
    //echo GetFileDir($_SERVER['PHP_SELF']);
    echo "</font>";
    echo "</font>";
?>
