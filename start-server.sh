#!/bin/bash

# Configurar variables de entorno de PHP para archivos grandes
export PHP_INI_SCAN_DIR=""
export PHP_INI_DIR=""

# Configurar límites de PHP
export PHP_UPLOAD_MAX_FILESIZE="50M"
export PHP_POST_MAX_SIZE="50M"
export PHP_MEMORY_LIMIT="256M"
export PHP_MAX_EXECUTION_TIME="300"

# Iniciar servidor Laravel con configuración personalizada
php -d upload_max_filesize=50M \
    -d post_max_size=50M \
    -d memory_limit=256M \
    -d max_execution_time=300 \
    -d max_input_time=300 \
    -d max_file_uploads=20 \
    -d max_input_vars=3000 \
    artisan serve --host=0.0.0.0 --port=8000
