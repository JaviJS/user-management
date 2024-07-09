#!/bin/bash

# Intentar ejecutar las migraciones hasta que se completen con éxito o hasta un máximo de 10 intentos
MAX_ATTEMPTS=10
ATTEMPT=0
RETRY_INTERVAL=30  # Intervalo de reintento en segundos

until php artisan migrate:refresh --seed --force || [ $ATTEMPT -eq $MAX_ATTEMPTS ]; do
    echo "Migration attempt failed. Waiting ${RETRY_INTERVAL} seconds before retrying..."
    sleep $RETRY_INTERVAL
    ((ATTEMPT++))
done

if [ $ATTEMPT -eq $MAX_ATTEMPTS ]; then
    echo "Max retries reached. Migration failed."
    exit 1
fi

echo "Migrations completed successfully."


php artisan test --stop-on-failure