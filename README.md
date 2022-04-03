# Sigma
![example workflow](https://github.com/ubermeows/sigma/actions/workflows/laravel.yml/badge.svg)
## Installation
```bash
cp .env.example .env
docker-compose up --build -d
docker-compose exec app composer up
docker-compose exec app php artisan key:generate
```
## Commandes
Voir le fichier `Makefile`.
## Commandes clips
Récuperer les clips
```
php8.1 artisan clip:store
php8.1 artisan clip:store --startedAt=2022-04-01
php8.1 artisan clip:store --startedAt=2022-04-01 --endedAt=2022-05-01
```
Update les clips
```
php8.1 artisan clip:update
```
## Jobs monitoring
```
php8.1 artisan queue:monitor clip-store,clip-update
```
## Twitch api
- Se connecter à la [console](https://dev.twitch.tv/console).
- Créer une [nouvelle application](https://dev.twitch.tv/console/apps/create).
- Le **URL de redirection OAuth** doit correspondre à celui de l'application, choisir **Website Integration** pour la **Catégorie**.
- Récupérer le **Identifiant client** dans **TWITCH_RAWAPI_CLIENT_ID** et le **Secret du client** dans **TWITCH_RAWAPI_CLIENT_SECRET**.
- Bisous.
## Endpoints
### games
```
# GET /api/games/search
$ curl https://sigma.megasaurus.fr/api/games/search
```
### clips
```
# GET /api/clips/search
$ curl https://sigma.megasaurus.fr/api/clips/search
```
### popular clips
```
# GET /api/clips/popular
$ curl https://sigma.megasaurus.fr/api/clips/popular
```
