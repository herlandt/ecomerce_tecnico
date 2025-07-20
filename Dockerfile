# Usamos una imagen oficial de PHP 8.2 con Composer y Node.js
FROM herloct/php-8.2-nginx-node-20:latest

# Establecemos el directorio de trabajo dentro de la caja
WORKDIR /var/www/html

# Copiamos los archivos de la aplicación a la caja
COPY . .

# Instalamos las dependencias de Composer y NPM, y construimos los assets
RUN composer install --no-dev --optimize-autoloader && \
    npm install && \
    npm run build

# Exponemos el puerto 80 para que el servidor web sea accesible
EXPOSE 80

# Comando que se ejecutará al encender la caja
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisor.conf"]