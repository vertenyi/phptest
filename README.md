# phptest

A feladat nincs teljesen kész vagy legalábbis nem olyan mint szerettem volna, de listáz, létrehozza az adatbázist ha kell, és fel is tölti.
Lehet kölcsönözni, visszaadni. a táblázat minden oszlop szerint rendezhető és 10 találatonként lapozható. Ez most php-vel van megoldva mert php feladatra jelentkezdtem, de adatmennyiségtől függően javascripttel vagy api hívással csinálom... amihez nekem most nem volt elég az idő... így a dátum és a rating intervallumra javascripttel szűrök csak rá és kiszürkítem, de nem veszem ki a találatokból, mert ahhoz a lapozó részt is újra kellett volna írnom.


Happymed Tesztfeladat -
Filmkölcsönző

Általánosságban a feladatról
A feladat az adatbázis-kezelési ismereteket, az objektumorientált PHP
programozást, a Docker és a Git használatát méri fel.
Kész backend keretrendszer (pl. Laravel, Symfony) használata nem
engedélyezett, de külső csomagokat lehet telepíteni Composer
segítségével.
A megoldás eltérhet a pontos instrukcióktól, de minél több követelmény
teljesül, annál értékesebb a megoldás.
Feladat: Filmkölcsönző alkalmazás készítése
Készíts egy egyszerű PHP programot, amely lehetővé teszi a filmek kezelését
és kölcsönzésük nyomon követését.
Követelmények
Adatbázis
1. Hozz létre egy adatbázist a következő táblákkal:
a. movies:
id (integer, primary key, auto-increment)
title (string)
genre (string)
release_year (integer)
rating (float)
b. rentals:
id (integer, primary key, auto-increment)
movie_id (integer, foreign key a movies táblára)
customer_name (string)

Happymed Tesztfeladat - Filmkölcsönző 2

rental_date (date)
return_date (date, nullable)

2. A program indításakor legyen lehetőség a táblák automatikus létrehozására
és feltöltésére legalább 30 random generált filmmel. Az adatok generálása
történhet saját logikával vagy külső könyvtárral.
Funkciók
1. Film lista megjelenítése (index.php):
Listázza az adatbázisban lévő összes filmet lapozhatóan.
Szűrési lehetőség a következőkre:
Műfaj
Kiadási év tartomány (minimum és maximum év)
Értékelés (minimum és maximum érték)
2. Kölcsönzés (rent.php):
Lehetővé teszi egy film kölcsönzését.
Ellenőrizze, hogy a film már nincs kölcsönadva, és adja hozzá a rentals
táblához az ügyfél nevét és a kölcsönzés dátumát.
3. Visszahozás (return.php):
Lehetővé teszi a kölcsönzött filmek visszavételét, és frissíti a
return_date mezőt a rentals táblában.
Frontend
1. Az alkalmazáshoz készíts frontend felületet vanilla JS-ben vagy Angular
használatával.
Docker használat
1. Készíts egy Dockerfile-t, amely biztosítja az alkalmazás futtatásához
szükséges környezetet.
Használj PHP 8.x alapú képfájlt.
Telepítsd a Composer-t a csomagok kezeléséhez.
Biztosítsd az alapvető bővítmények telepítését (pl. PDO, mysqli).

Happymed Tesztfeladat - Filmkölcsönző 3

2. Készíts egy docker-compose.yml fájlt, amely tartalmazza:
PHP konténer: Az alkalmazás futtatásához.
MySQL vagy MariaDB konténer: Az adatbázis kezeléséhez.
Git használat
A feladat verziókezeléséhez használj git-et.
Ha korábban írt kódot adsz hozzá a házi feladathoz (framework, skeleton),
kérlek, tedd ezt egy külön commitban.
Az elkészült feladatot töltsd fel egy GitLab repository-ba, és oszd meg
velünk ( Maintainer jogkörrel):
@matevojts
@poci
@beo08
Ami kiemelhet a többi jelölt közül:
Automata tesztek
API contract (pl. OpenAPI)
Hibakezelés
