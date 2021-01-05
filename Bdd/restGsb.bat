cd C:\wamp64\bin\mysql\mysql5.7.26\bin
.\mysqldump.exe -u userGsb -psecret gsb_frais >C:\Users\orsini.manon\Documents\Actuel\GSB\Bdd\savegsb.sql
ren C:\Users\orsini.manon\Documents\Actuel\GSB\Bdd\savegsb.sql savegsb_%date:~6,4%-%date:~3,2%-%date:~0,2%.sql