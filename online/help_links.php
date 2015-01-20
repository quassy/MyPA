<?php

/*
 * MyPHPpa
 * Copyright (C) 2003, 2007 Jens Beyer
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

require "options.php";
require "dblogon.php";

require "header.php";
my_header("",0,0);

require "msgbox.php";

titlebox("Links");
?>

<center>
<table border=1 width="650" cellpadding="3">
<tr class="a"><th colspan=2>A collection of links related to this game</th></tr>
<tr class="b"><th width="100">Link</th>
              <th>Description</th></tr>
<tr><td>&nbsp;</td><td>If you want to build your own toolbox: database 
dumps can be found every 15 minutes on<br>
&nbsp;&nbsp;/img/universe.txt<br>
&nbsp;&nbsp;/img/galaxy.txt</td></tr>
<tr><td align=center><a href="http://caladan.duke.de:31339/pa" target="_blank"><img border=0 src="http://caladan.duke.de:31337/gfx/pa/speedPA-Logo88x31_32-made_by_melcom.gif"></a></td>
<td>
There is a rough quickly done port of the -={BP}=- Toolbox available for 
everyone here now: <br>
<br>
http://caladan.duke.de:31339/pa<br> 
<br>
It is a quick and rough port - some graphical stat options dont work yet, the 
BC doesnt have PDS fields, the stats where done hastily in a night etc. etc. 
but at least the design _rocks_ :P <br>
<br>
I may write some explanations of how to use etc. later ... (dont get your hopes 
up - people wait for that since PA rd4 ;). For now - if you see a weird icon - 
click on it - it may be one of the helppages ;) <br>
<br>
The data is updated from 15 minute snapshots every 15 minutes. <br>
<br>
Have fun, <br>
Bit.<br>
</td></tr>
<tr><td align="center"><a href="http://www.planetarion.com" target="_blank">PA</a>
</td><td>
<br>For all who didnt know it - Real PA is still alive
<br>
</td></tr>
<!--
<tr><td colspan=2>
<table border=0 width=100%>
<tr class="c0"><td><a href="http://www.last-horizon.co.uk" target="_blank">www.last-horizon.co.uk</a></td><td>One game 30 s and one with <b>5 s</b> ticks</td></tr>
<tr class="c1"><td><a href="http://www.unitywars.com" target="_blank">www.unitywars.com</a></td><td>3 min ticks</td></tr>
</table>
</td></tr>
-->
</table>
</center>

<?php
require "footer.php";
?>

