#!/bin/bash
# Script de inicio para Railway
# Usa el puerto proporcionado por Railway o 8080 por defecto

PORT=${PORT:-8080}
echo "Iniciando servidor PHP en puerto $PORT"
php -S 0.0.0.0:$PORT -t . index.php

