#!/bin/sh

rm -f /home/khan/tmp.db/universe.db
rm -f /home/khan/tmp.db/galaxy.db
rm -f /home/khan/tmp.db/tick.db

mysql -u root -ppassword planetarion <<EOF

SELECT now(), tick FROM general
 INTO OUTFILE '/home/khan/tmp.db/tick.db'
 FIELDS terminated by ';';

SELECT x, y, z, planetname, leader, score, 
 metalroids + crystalroids + eoniumroids + uniniroids as size 
 FROM planet ORDER BY x,y,z ASC 
 INTO OUTFILE '/home/khan/tmp.db/universe.db' 
 FIELDS terminated by ';';

SELECT p.x AS x , p.y AS y, g.name, SUM(p.score) AS score,
 SUM(metalroids + crystalroids +eoniumroids + uniniroids) AS size
 FROM planet AS p, galaxy AS g 
 WHERE g.x=p.x AND g.y = p.y
 GROUP by x, y ORDER BY x, y
 INTO OUTFILE '/home/khan/tmp.db/galaxy.db'
 FIELDS terminated by ';';
EOF

echo '# Date, Tick' > /home/khan/tmp.db/universe.txt 
echo -n '# ' >> /home/khan/tmp.db/universe.txt
cat /home/khan/tmp.db/tick.db >> /home/khan/tmp.db/universe.txt
echo '# x y z name leader score size' >> /home/khan/tmp.db/universe.txt
cat /home/khan/tmp.db/universe.db | sed 's/&amp\\;/\&/g; s/&quot\\;/"/g; s/&lt\\;/</g; s/&gt\\;/>/g; s/\\;//g' >> /home/khan/tmp.db/universe.txt

echo '# Date, Tick' > /home/khan/tmp.db/galaxy.txt 
echo -n '# ' >> /home/khan/tmp.db/galaxy.txt
cat /home/khan/tmp.db/tick.db >> /home/khan/tmp.db/galaxy.txt
echo '# x y name score size' >> /home/khan/tmp.db/galaxy.txt
cat /home/khan/tmp.db/galaxy.db | sed 's/&amp\\;/\&/g; s/&quot\\;/"/g; s/&lt\\;/</g; s/&gt\\;/>/g; s/\\;//g' >> /home/khan/tmp.db/galaxy.txt

mv /home/khan/tmp.db/universe.txt /home/khan/tmp.db/galaxy.txt /home/khan/online/img

rm -f /home/khan/tmp.db/universe.db
rm -f /home/khan/tmp.db/galaxy.db
rm -f /home/khan/tmp.db/tick.db

