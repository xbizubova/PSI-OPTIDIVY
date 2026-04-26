# OPTIDIVY

Laravel aplikácia sa nachádza v priečinku `app/optidivy`.

## Požiadavky
- PHP 8.3 alebo novšie
- Composer
- Node.js LTS

## Lokálne spustenie
1. Otvorte priečinok `app/optidivy`.
2. V termináli nainštalujte PHP balíky:
	```bash
	composer install
	```
3. Nainštalujte frontend balíky:
	```bash
	npm install
	```
4. Ak súbor `.env` neexistuje, skopírujte ho z `.env.example`.
5. Vygenerujte APP key:
	```bash
	php artisan key:generate
	```
6. SQLite databáza sa používa predvolene. Ak súbor `database/database.sqlite` neexistuje, vytvorte prázdny súbor s týmto názvom.
7. Spustite migrácie:
	```bash
	php artisan migrate --force
	```

8. Spustite seedery, ak chcete naplniť databázu testovacími dátami:
    ```bash
    php artisan db:seed --force
    ```
9. Spustite frontend build server:
	```bash
	npm run build
	```
10. Spustite Laravel server:
	```bash
	php artisan serve
	```

Potom otvorte adresu, ktorú Artisan vypíše, zvyčajne `http://127.0.0.1:8000`.

## Čo sa nemá commitovať
- `vendor/`
- `node_modules/`
- `public/build/`
- `bootstrap/cache/*` okrem `.gitignore`
- `.env`
