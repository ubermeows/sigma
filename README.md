# Sigma

## Installation

```bash
cp .env.example .env
docker-compose up --build -d
docker-compose exec app composer up
docker-compose exec app php artisan key:generate
```

## Commandes
Voir le fichier `Makefile`.

## Twitch api
- Se connecter à la [console](https://dev.twitch.tv/console).
- Créer une [nouvelle application](https://dev.twitch.tv/console/apps/create).
- Le **URL de redirection OAuth** doit correspondre à celui de l'application, choisir **Website Integration** pour la **Catégorie**.
- Récupérer le **Identifiant client** dans **TWITCH_RAWAPI_CLIENT_ID** et le **Secret du client**dans **TWITCH_RAWAPI_CLIENT_SECRET**.
- Bisous.
