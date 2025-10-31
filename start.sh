#!/bin/bash
# Script de inicio para Railway
# Usa el puerto proporcionado por Railway o 8080 por defecto
# Usa router.php para servir archivos estáticos correctamente

PORT=${PORT:-8080}
echo "Iniciando servidor PHP en puerto $PORT"
php -S 0.0.0.0:$PORT router.php

