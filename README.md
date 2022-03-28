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