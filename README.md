# YuraiCars - Sistema de Alquiler de Vehículos

Sistema moderno de alquiler de vehículos de lujo desarrollado con Laravel y tecnologías frontend de vanguardia.

## 🚀 Características

- **Diseño Futurista**: Interfaz ultra moderna con efectos 3D, glassmorphism y animaciones avanzadas
- **Responsive**: Diseño completamente adaptable a todos los dispositivos
- **Tecnologías Avanzadas**: Three.js para gráficos 3D, GSAP para animaciones fluidas
- **Sistema de Reservas**: Gestión completa de alquileres de vehículos
- **Panel de Usuario**: Perfil y gestión de reservas

## 🛠️ Tecnologías

- **Backend**: Laravel 12.x, PHP 8.4
- **Frontend**: Tailwind CSS, Alpine.js, Livewire
- **3D/Animaciones**: Three.js, GSAP
- **UI Components**: Livewire Flux
- **Base de Datos**: MySQL/PostgreSQL
- **Cache**: Redis

## 📋 Requisitos Previos

- PHP 8.4+
- Composer
- Node.js 18+
- npm/yarn
- Docker & Docker Compose (opcional pero recomendado)

## ⚡ Instalación Rápida

### Opción 1: Con Docker (Recomendado)

1. **Clonar el repositorio**
   ```bash
   git clone <repository-url>
   cd YuraiCars-1
   ```

2. **Iniciar servicios con Docker**
   ```bash
   docker-compose up -d
   ```

3. **Instalar dependencias**
   ```bash
   composer install
   npm install
   ```

4. **Configurar entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Migrar base de datos**
   ```bash
   php artisan migrate --seed
   ```

6. **Compilar assets**
   ```bash
   npm run dev
   ```

### Opción 2: Instalación Local

1. **Configurar base de datos MySQL local**
2. **Seguir pasos 1, 3-6 de la opción anterior**
3. **Ejecutar servidor**
   ```bash
   php artisan serve
   ```

## 🐳 Servicios Docker

El archivo `docker-compose.yml` incluye:

- **MySQL 8.0**: Base de datos principal (puerto 3306)
- **Redis**: Cache y sesiones (puerto 6379)
- **Mailpit**: Testing de emails (puerto 8025 para UI, 1025 para SMTP)

### Comandos Docker útiles

```bash
# Iniciar servicios
docker-compose up -d

# Ver logs
docker-compose logs -f

# Parar servicios
docker-compose down

# Resetear volúmenes
docker-compose down -v
```

## 🎨 Desarrollo Frontend

### Compilar assets en desarrollo
```bash
npm run dev
```

### Compilar para producción
```bash
npm run build
```

### Características del diseño:
- **Efectos 3D**: Modelo de carro rotando con Three.js
- **Glassmorphism**: Tarjetas con efecto de vidrio esmerilado
- **Animaciones**: Efectos de flotación y transiciones suaves
- **Gradientes Neón**: Colores vibrantes con efectos de humo
- **Responsive**: Perfecto en desktop, tablet y móvil

## 🗄️ Base de Datos

### Migrar
```bash
php artisan migrate
```

### Seeders
```bash
php artisan db:seed
```

### Refresh completo
```bash
php artisan migrate:fresh --seed
```

## 📧 Email Testing

Con Mailpit corriendo, puedes:
- Ver emails en: http://localhost:8025
- Configurar SMTP en: `127.0.0.1:1025`

## 🔧 Comandos Útiles

```bash
# Limpiar cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Testing
php artisan test
```

## 🏗️ Estructura del Proyecto

```
YuraiCars-1/
├── app/                    # Lógica de aplicación
├── resources/
│   ├── views/             # Vistas Blade
│   ├── js/                # JavaScript (Three.js, animaciones)
│   └── css/               # Estilos (Tailwind CSS)
├── public/                # Assets públicos
├── routes/                # Definición de rutas
├── database/              # Migraciones y seeders
└── docker-compose.yml     # Servicios de desarrollo
```

## 🚀 Deployment

Para deployment en producción:

1. Configurar variables de entorno apropiadas
2. Compilar assets: `npm run build`
3. Optimizar Laravel: `php artisan optimize`
4. Configurar servidor web (Apache/Nginx)

## 🤝 Contribuir

1. Fork el proyecto
2. Crear rama de feature: `git checkout -b feature/nueva-funcionalidad`
3. Commit cambios: `git commit -am 'Añadir nueva funcionalidad'`
4. Push a la rama: `git push origin feature/nueva-funcionalidad`
5. Crear Pull Request

## 📝 Licencia

Este proyecto es propiedad privada. Todos los derechos reservados.
