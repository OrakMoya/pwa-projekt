# PWA PROJEKT
---
Ovo je projekt iz Programiranja Web Aplikacija, stvoren pomoću Laravel 11, InertiaJS i Svelte.

Ako vam se neda skidat i pokretat lokalno, ili ne znate, ili sam nešt ne radi, live verzija ove stranice je dostupna na https://pwa.bjelopic.com Slobodno se igrajte.

## Pokretanje lokalno
Treba Vam PHP, Composer, NodeJS te NPM i neki SQL server (ja koristim Sqlite).

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
	1. Pokrenite `php artisan serve` (spajate se na IP koji ova naredba ispiše)
	2. Paralelno pokrenite `npm run dev`
10. Uzivajte

## Korištenje
Nakon prvog pokretanja, stranica je prazna. Ako stisnete na "Administracija", preusmjeri vas na Login, zbog toga što niste prijavljeni.

Stisnite na "Sign up" ako nemate račun, ako imate prijavite se. Nakon registracije se morate ulogirati.

### Posts
Nakon prijave vas preumjeri na `admin/posts`. Tu možete dodavati prazne objave koje onda možete editat.

#### Editor objava
Objave su isprva sakrivene sa naslovne stranice. Da se pokažu, editajte objavu i stisnite switch pokraj ikone oka.

Možete dodavat/izmjeniti naslovnu sliku klikom na to područje. Prihvaća slike između 50KB i 10MB.

Za sami uređivać teksta koristim EditorJS. Tu možete uređivat tekst na jednostavan način (tipa Headinge, Bold, Italic itd.)

Kada ste gotovi, stisnete Save.

### Users
Tu se izlistaju svi korisnici koji su registrirani. Možete im promjeniti ime i lozinku (mijenjanje lozinke ne bude odjavilo tog korisnika sa stranice, iskreno nisam znao kak to napravit).

Možete obrisati bilo kojeg korisnika.

### Naslovna stranica
Tu se izlistaju sve javne objave na stranici, poredane prvo po kategoriji ASC pa po vremenu stvaranja DESC.

Stiskom na kategoriju iznad objave, izlistaju se sve objave u toj kategoriji.

Stiskom na sliku ili naslov, možete pročitati objavu.

Pri vrhu stranice su nekoliko hardkodiranih kategorija. Ti linkovi nisu ništa posebno, samo shortcut na specifičan URL sa GET parametrom `?category=`.

## Kod
Datoteke/direktoriji koje bi vas mogle zanimat:

1. `routes/` (specifično `admin.php` i `web.php`) -> Tu su definirani routeovi za server. Za svaki route definirana je metoda i koju metodu koje klase poziva kad joj se tak pristupi.
2. `resources/js/Pages/` -> `.svelte` datoteke koje InertiaJS koristi za renderanje stranice. Npr. pozivanjem `Inertia::render('Home');` će se renderirati `Home.svelte`, a pozivanjem `Inertia::render('Admin/Posts');` će se renderirati `Admin/Posts.svelte`
3. `app/Http/Controllers/` -> Kontroler klase za sve na stranici.
4. `app/Http/Requests/` -> Datoteke koje definiraju validaciju za requestove usmjerene na stranicu. Npr. `UpdatePostRequest.php` definira sva pravila koja se moraju zadovoljit kada updateate objavu (tu se provjerava npr. da li je uploadana slika zaparvo slika, njena veličina itd...)
4. 'database/migrations/' -> Definicije kako stvoriti pojedine tablice u bazi podataka na stranici.
5. `storage/app/public/` -> Javna mapa datoteka servera. Tu se spremaju slike za objave.
6. `templates/` -> Predlošci po kojima sam radio izgled stranice.
