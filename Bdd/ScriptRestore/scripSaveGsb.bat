cd C:\wamp64\bin\mysql\mysql5.7.26\bin
.\mysqldump.exe -u userGsb -psecret  gsb_frais >C:\Users\vedrenne.alexis\Desktop\Ressource\GSB_AppliMVC\Bdd\SauvegardeBDD\saveGSB.sql
ren C:\Users\vedrenne.alexis\Desktop\Ressource\GSB_AppliMVC\Bdd\SauvegardeBDD\saveGSB.sql saveGSB_%time:~0,2%%time:~3,2%-%date:~0,2%%date:~3,2%%date:~6,4%.sql