# PWA PROJEKT
---
Ovo je projekt iz Programiranja Web Aplikacija, stvoren pomoću Laravel 11, InertiaJS i Svelte.

Live verzija ove stranice: https://pwa.bjelopic.com

## Pokretanje lokalno
Treba vam PHP, Composer, NodeJS te NPM i neki SQL server (ja koristim Sqlite).

1. Skinite repozitorij (main) i negdje ga dekompresirajte
2. Kopirajte/preimenujte `.env.example` u `.env`
3. U `.env`, podesite postavke baze podataka
	1. Za SQLite, `DB_CONNECTION=sqlite3` pa postavite `DATABASE_PATH=` na neku potpuno praznu `database.sqlite` datoteku  na disku koja služi kao baza podataka
	2. Za MySQL, `DB_CONNECTION=mysql` pa postavite host, port itd.
	3. Ako koristite MySQL, stvorite bazu `pwa-projekt` u njoj (ili kak god da ste ju nazvali u `.env` pod `DB_DATABASE`)
	3. Spremite i zatvorite `.env` datoteku
3. Izvršite `composer install` u mapi projekta
4. Izvršite `npm install` u mapi projekta
5. Izvršite `php artisan key:generate` u mapi projekta
6. Izvršite `php artisan migrate:fresh`
7. Izvršite `php artisan storage:link` (ak ovo ne napravite, slike koje uploadate se nebudu pravilno učitavale)
8. Pokrenite server
	1. Pokrenite `php artisan serve`
	2. Paralelno pokrenite `npm run dev`
10. Uzivajte