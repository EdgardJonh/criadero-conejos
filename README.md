# Proyecto Laravel: CRUD de Conejos

## Requisitos
- PHP 8.1+
- Composer
- MySQL
- Node.js y npm (para assets de Breeze)

## Instalación

1. **Clona el repositorio y entra al directorio:**
   ```bash
   git clone <repo-url>
   cd <directorio>
   ```

2. **Instala dependencias de PHP:**
   ```bash
   composer install
   ```

3. **Instala dependencias de frontend:**
   ```bash
   npm install && npm run build
   ```

4. **Copia el archivo de entorno y configura la base de datos:**
   ```bash
   cp .env.example .env
   # Edita .env y pon tus datos de MySQL
   ```

5. **Genera la clave de la app:**
   ```bash
   php artisan key:generate
   ```

6. **Ejecuta las migraciones:**
   ```bash
   php artisan migrate
   ```

7. **Crea el enlace de storage:**
   ```bash
   php artisan storage:link
   ```

8. **Inicia el servidor:**
   ```bash
   php artisan serve
   ```

## Uso

- Accede a `http://localhost:8000`.
- Regístrate o inicia sesión.
- Accede al panel de administración y gestiona conejos.
- Sube imágenes (máx. 1MB por imagen, JPG/PNG).
- Puedes agregar, editar, eliminar conejos y gestionar sus fotos (incluye previsualización y eliminación avanzada).

## Endpoint público para landingpage

- **Ruta:** `/api/conejos`
- **Método:** GET
- **Descripción:** Devuelve todos los conejos y sus propiedades en formato JSON.

## Funcionalidades principales
- Autenticación de usuarios (Laravel Breeze)
- CRUD completo de conejos
- Subida de imágenes principal y adicionales (con previsualización y eliminación)
- Panel de administración
- Endpoint público para integración con landingpage

## Notas
- Si subes muchas imágenes grandes, asegúrate de que tu servidor soporte los límites de tamaño configurados en `.htaccess`.
- El sistema está preparado para ser extendido fácilmente con más campos o funcionalidades.

---

¿Dudas? ¡Contáctame!
