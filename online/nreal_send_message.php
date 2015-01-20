<?php

/*
 * MyPHPpa
 * Copyright (C) 2003 Jens Beyer
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

function insert_message ($target_id,  $tname, $subject, $text, $copy=1) {
  global $db, $Planetid;

  $q = "INSERT INTO mail SET planet_id='$target_id',sender_id='$Planetid',".
       "date=now(),subject='$subject',text='$text', ref=2";
  $res = mysql_query ($q, $db);
  $mid = mysql_insert_id();

  if ($res) {
    $msg = "Message was succesfully sent to ($tname)";
    mysql_query ("UPDATE planet SET has_mail=1 WHERE id='$target_id'", $db);

    mysql_query ("INSERT INTO msg SET mail_id='$mid', ".
                 "planet_id='$target_id'", $db);
    if ($copy) {
      mysql_query ("INSERT INTO msg SET mail_id='$mid', ".
                   "planet_id='$Planetid',folder=2,old=1", $db);
    }
  } else {
    $msg = "Failed to send message";
  }
  return $msg;
}

function send_message_form ($width) {
  global $reply, $forward, $send_to, $mail_id, $Planetid, $db;
  global $gal, $cluster, $hc, $alc;

  echo <<<EOF
<form method="post" action="$PHP_SELF">
<table width="$width" border="1">
<tr><th class="a" colspan="2">
EOF;

  $text = "";
  $subject = "";
  $x = "";
  $y = "";
  $z = "";

  if ($reply || $forward) {

    if($reply) {
      $q = "SELECT mail.subject AS subject, mail.text AS text, ".
	 "planet.x AS x, planet.y AS y, planet.z AS z FROM mail, planet ".
	 "WHERE mail.id='$mail_id' AND mail.planet_id='$Planetid' ".
	 "AND planet.id=mail.sender_id";
    } else {
      $q = "SELECT mail.subject AS subject, mail.text AS text, mail.sender_id ".
	 "FROM mail, msg WHERE mail.id='$mail_id' AND msg.mail_id=mail.id ".
	 "AND msg.planet_id='$Planetid'";
    }

    $result = mysql_query ($q, $db);

    if ($result && mysql_num_rows($result) == 1) {
      $row=mysql_fetch_array($result);

      $subject = $row[0];
      $text = ereg_replace ("<", "&lt;", $row[1]);
      if ($reply) {
        $x = $row[2];
        $y = $row[3];
        $z = $row[4];
      } else {
        $sender_id = $row[2];
      }
    }

    if ($reply) {
      echo "Reply to message</th></tr>";
      $subject = "Re: $subject";
      $text = "--------------------\n$text";
    } else {
      $sr = get_coord_name($sender_id);
      echo "Forward message</th></tr>";
      $subject = "Fw: $subject";
      $text = "Forwarded Message from: $sr[4] of $sr[3] ".
              "($sr[0]:$sr[1]:$sr[2])\n\n$text"; 
    }

  } else {
    if ($cluster) {
      if($gal) {
        echo "Send galaxy message</th></tr>";
      } else {
        echo "Send cluster message</th></tr>";
      }
    } else if ($hc) {
      echo "Send HC message</th></tr>";
    } else if ($alc) {
      echo "Send alliance member message</th></tr>";
    } else {
      echo "Send new message</th></tr>";
    }
  }

  if ($send_to) {
    $coords = get_coord ($send_to);

    if ($coords) {
      $x = $coords[0];
      $y = $coords[1];
      $z = $coords[2];
    }
  }

  echo <<<EOF
<tr><th align="left" class="a" width="22%">To:</th>
<th align="left" class="a">Subject:</th></tr>
<tr><td width="22%">
EOF;
  if ($cluster) {
    if ($gal) {
      echo "<b>Galaxy ($cluster:$gal)</b>";
      echo "<input type=\"hidden\" name=\"gal\" value=\"$gal\">\n";
    } else {
      echo "<b>Cluster #$cluster</b>";
    }
    echo "<input type=\"hidden\" name=\"cluster\" value=\"$cluster\">\n";
  } else if ($hc) {
    echo "<b>HC of [$hc]</b>".
      "<input type=\"hidden\" name=\"hc\" value=\"$hc\">\n";
  } else if ($alc) {
    echo "<b>Members of [$alc]</b>".
      "<input type=\"hidden\" name=\"alc\" value=\"$alc\">\n";
  } else {
    echo <<<EOF
<input type="text" name="x" size="2" maxlength="2" value="$x">
<input type=text name="y" size="2 maxlength="2" value="$y">
<input type=text name="z" size="2 maxlength="2" value="$z">
EOF;
  }

  echo <<<EOF
</td><td width="78%" align="left">
<input type="text" name="subject" size="30" maxlength="50" value="$subject">
</td></tr><tr><td colspan="2">
<textarea name="text" cols="60" rows="8" wrap="virtual">$text</textarea>
</td></tr><tr><td colspan="2" align="center">
<input type="submit" name="submit" value="       Send       ">
&nbsp;&nbsp; &nbsp;
<input type="reset" value="Clear message">
&nbsp;&nbsp; &nbsp;
</td>
</tr>
</table>
</form>
EOF;

}

if ($reply) {
     $mail_id = $reply; 
} else if ($forward) {
     $mail_id = $forward; 
}

if ($submit) {

  if (! $subject) $subject = "";
  if (! $text) $text = "";

  if ($x && $y && $z) {
    $target_id = get_id ($x, $y, $z);

    if ($target_id) {
      $msg = insert_message ($target_id, "($x:$y:$z)", $subject, $text);
    } else {
      $msg = "<span class=\"red\">Invalid target coordinates</span>";
    }
  } else {
    if ($cluster) {
      if ($gal) {
        $q = "SELECT id FROM planet WHERE x='$cluster' AND y='$gal'";
        $msg = "Message sent to galaxy";
      } else {
        $q = "SELECT moc FROM galaxy WHERE x='$cluster'";
        $msg = "Message sent to cluster";
      }
      $resp = mysql_query ($q, $db);
      $cnt = mysql_num_rows($resp);
    
      while ($row=mysql_fetch_row($resp)) {

        $q = "INSERT INTO mail SET planet_id='$row[0]',sender_id='$Planetid',".
             "date=now(),subject='$subject',text='$text', ref=1";
        $res = mysql_query ($q, $db);
        $mid = mysql_insert_id();

        if ($res) {
          if ($row[0] != $Planetid) {
            mysql_query ("UPDATE planet SET has_mail=1 WHERE id='$row[0]'", $db);
            mysql_query ("INSERT INTO msg SET mail_id='$mid', ".
                         "planet_id='$row[0]'", $db);
          } else {
            mysql_query ("INSERT INTO msg SET mail_id='$mid', ".
                         "planet_id='$Planetid',folder=2,old=1", $db);
          }
        }      
      }
    } else if ($hc) {
      $q = "SELECT hc FROM alliance WHERE tag='$hc'";
      $res = mysql_query ($q, $db);
      if ($res && mysql_num_rows($res)>0) {
        $row = mysql_fetch_row($res);
        $msg = insert_message ($row[0], "[$hc]", "HC msg: ".$subject, $text, 0);
      }
    } else if ($alc) {
      $q = "SELECT id FROM alliance WHERE tag='$alc'";
      $res = mysql_query ($q, $db);
      if ($res && mysql_num_rows($res)==1) {
        $row = mysql_fetch_row($res);

	$q = "SELECT id FROM planet WHERE alliance_id=$row[0]";
        $resp = mysql_query ($q, $db);
        $cnt = mysql_num_rows($resp);

        while ($cnt && $row=mysql_fetch_row($resp)) {
          $q = "INSERT INTO mail SET planet_id='$row[0]',sender_id='$Planetid',".
               "date=now(),subject='[$alc]: $subject',text='$text', ref=1";
          $res = mysql_query ($q, $db);
          $mid = mysql_insert_id();

          if ($res) {
            if ($row[0] != $Planetid) {
              mysql_query ("UPDATE planet SET has_mail=1 WHERE id='$row[0]'", $db);
              mysql_query ("INSERT INTO msg SET mail_id='$mid', ".
                           "planet_id='$row[0]'", $db);
            } else {
              mysql_query ("INSERT INTO msg SET mail_id='$mid', ".
                           "planet_id='$Planetid',folder=2,old=1", $db);
            }
          }
        }
      }
    }
  }
}

?>
