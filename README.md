# Environnement Docker — Poney Club de Bazas

## Services
- `app` : PHP 8.3 + Apache, extensions Symfony (pdo_mysql, intl, zip, opcache), Composer — http://localhost:8080
- `database` : MySQL 8.4 LTS — accessible depuis Windows sur le port 3307
- `phpmyadmin` : interface web de la base — http://localhost:8081

## Démarrage (Windows, Docker Desktop lancé)
1. Ouvrir PowerShell dans ce dossier.
2. `docker compose up -d --build`
3. `docker compose ps` : les 3 services doivent être « running ».

## Arrêter / relancer
- Arrêter : `docker compose stop`
- Relancer : `docker compose start`
- Tout supprimer sauf la base : `docker compose down`
- Tout supprimer y compris la base : `docker compose down -v`

## Entrer dans le conteneur PHP
`docker compose exec app bash`

## Connexion à la base (depuis Symfony, dans le conteneur)
`DATABASE_URL="mysql://poneyclub:poneyclub@database:3306/poneyclub?serverVersion=8.4&charset=utf8mb4"`
(`database` = nom du service Docker, pas `127.0.0.1`.)
