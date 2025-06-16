# YuraiCars - Sistema de Alquiler de Vehículos

Sistema web completo para alquiler de vehículos desarrollado con Laravel, Filament y Livewire.

## 🚀 Características Principales

### Sistema de Administración (Filament)
- **Gestión completa de vehículos** con imágenes y características
- **Administración de usuarios** y perfiles
- **Sistema avanzado de rentals** con múltiples estados
- **🆕 Sistema de pagos múltiples** con soporte para pagos adicionales
- **Dashboard con estadísticas** en tiempo real

### Sistema de Pagos Múltiples
#### ✨ Nuevas Funcionalidades

**1. Pagos Adicionales Automáticos**
- Al extender la fecha final de un rental, se crea automáticamente un pago adicional pendiente
- Solo se calcula el monto de los días extras (no se recalcula todo el rental)
- Notificaciones automáticas al administrador sobre pagos pendientes

**2. Procesamiento de Pagos en Admin**
- Botón "Procesar Pago Adicional" visible cuando hay montos pendientes
- Formulario con selección de método de pago (Tarjeta de Crédito, Débito, Efectivo, Transferencia)
- Validación de montos (no puede exceder el monto pendiente)
- Descripciones personalizables para cada pago

**3. Vista Administrativa Mejorada**
- **Información Financiera Completa**: Monto total, pagado, pendiente
- **Historial de Pagos**: Lista todos los pagos (inicial y adicionales) con detalles
- **Estados de Pago con Colores**: Verde (pagado), Naranja (pendiente), Rojo (sin pagos)
- **Filtros**: Por estado de rental y estado de pago

**4. Vista del Cliente Actualizada**
- **Resumen Financiero**: Estado completo de pagos del rental
- **Historial Detallado**: Cada pago con su descripción, método, estado y fecha
- **Facturas Individuales**: Descarga de factura para cada pago específico
- **Factura Completa**: Resumen de todos los pagos del rental

**5. Sistema de Facturas Múltiples**
- **Factura Individual**: Para cada pago (inicial o adicional)
- **Factura Completa**: Resumen total del rental con todos los pagos
- **Diseño Profesional**: PDF con información detallada y branding
- **Identificación Única**: Números de factura diferenciados (INI-, ADD-, COMP-)

### Modelos y Relaciones Actualizadas

**Rental Model**
```php
// Relaciones
public function payments(): HasMany // Múltiples pagos por rental

// Nuevos Atributos
$rental->total_amount           // Monto total del rental
$rental->paid_amount           // Total pagado (suma de pagos exitosos)
$rental->pending_amount        // Monto pendiente
$rental->payment_status        // Estado general de pagos
$rental->initial_payment       // Pago inicial
$rental->additional_payments   // Pagos adicionales

// Nuevos Métodos
$rental->createAdditionalPayment($amount, $days, $description)
$rental->calculateAdditionalAmount($newEndTime)
```

**Payment Model**
```php
// Nuevos Campos
payment_type        // 'initial' o 'additional'
description         // Descripción del pago
additional_days     // Días adicionales (para pagos adicionales)

// Nuevos Atributos
$payment->is_initial_payment
$payment->is_additional_payment
$payment->formatted_description
$payment->formatted_status
$payment->formatted_payment_method
$payment->formatted_amount

// Nuevos Métodos
$payment->markAsSuccessful($method)
$payment->markAsFailed()
```

### Flujo de Trabajo

1. **Creación del Rental**: Se crea el rental con fechas iniciales
2. **Pago Inicial**: Se procesa el pago por el período original
3. **Extensión**: Al cambiar la fecha final a una posterior:
   - Se calcula automáticamente el monto adicional
   - Se crea un pago adicional pendiente
   - Se notifica al administrador
4. **Procesamiento**: El administrador procesa el pago adicional
5. **Facturas**: El cliente puede descargar facturas individuales o completa

### Base de Datos

**Nueva Migración: `add_payment_type_to_payments_table`**
```sql
ALTER TABLE payments ADD COLUMN payment_type VARCHAR(255) DEFAULT 'initial';
ALTER TABLE payments ADD COLUMN description TEXT NULL;
ALTER TABLE payments ADD COLUMN additional_days INTEGER NULL;
```

### Datos de Prueba

Ejecuta el seeder para crear ejemplos:
```bash
php artisan db:seed --class=MultiplePaymentsSeeder
```

Esto creará:
- Un rental completamente pagado (inicial + adicional)
- Un rental con pago pendiente para testing

### Funcionalidades Técnicas

**Validaciones**
- Montos no pueden ser negativos
- Pagos adicionales no pueden exceder el monto pendiente
- Fechas de extensión deben ser posteriores a la original

**Seguridad**
- Transacciones de base de datos para operaciones críticas
- Validación de permisos en el panel de administración
- Prevención de pagos duplicados

**Rendimiento**
- Carga eager de relaciones (payments, vehicle, user)
- Uso de accesorios (accessors) para cálculos frecuentes
- Índices en campos de búsqueda frecuente

## 📋 Instalación

```bash
# Clonar repositorio
git clone [repo-url]
cd YuraiCars

# Instalar dependencias
composer install
npm install

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Configurar base de datos
php artisan migrate
php artisan db:seed

# Datos de prueba para pagos múltiples
php artisan db:seed --class=MultiplePaymentsSeeder

# Ejecutar aplicación
php artisan serve
npm run dev
```

## 🔧 Configuración

### Panel de Administración
- URL: `/admin`
- Crear usuario admin: `php artisan make:filament-user`

### Variables de Entorno Importantes
```env
# Base de datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=yuraicars
DB_USERNAME=root
DB_PASSWORD=

# PDF Generation
PDF_GENERATOR=dompdf
```

## 🛠️ Tecnologías

- **Backend**: Laravel 11
- **Admin Panel**: Filament 3
- **Frontend**: Livewire 3, Alpine.js
- **Base de Datos**: MySQL
- **PDF**: DomPDF
- **Estilos**: Tailwind CSS

## 📱 Funcionalidades del Cliente

- Búsqueda y filtrado de vehículos
- Sistema de reservas completo
- Pagos con Stripe
- **Gestión de perfil**
- **Vista detallada de rentals con historial de pagos**
- **Descarga de facturas múltiples**

## 👨‍💻 Desarrollo

### Estructura de Archivos Clave

```
app/
├── Models/
│   ├── Rental.php              # Modelo principal con pagos múltiples
│   └── Payment.php             # Modelo de pagos con tipos
├── Filament/Admin/Resources/
│   ├── RentalResource.php      # Gestión de rentals
│   └── RentalResource/Pages/
│       ├── EditRental.php      # Procesamiento de pagos adicionales
│       └── ViewRental.php      # Vista detallada con historial
├── Livewire/
│   └── RentalDetails.php       # Vista del cliente con pagos
└── resources/views/pdf/
    ├── payment-invoice.blade.php        # Factura individual
    └── complete-rental-invoice.blade.php # Factura completa
```

### Comandos Útiles

```bash
# Crear migración
php artisan make:migration create_table_name

# Crear seeder
php artisan make:seeder SampleSeeder

# Limpiar caché
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Regenerar autoload
composer dump-autoload
```

## 🤝 Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver `LICENSE` para más detalles.

---

## 🆕 Últimas Actualizaciones

### v2.0 - Sistema de Pagos Múltiples
- ✅ Soporte completo para pagos adicionales
- ✅ Interfaz administrativa mejorada
- ✅ Vista del cliente con historial de pagos
- ✅ Sistema de facturas múltiples
- ✅ Datos de prueba automatizados
- ✅ Validaciones y seguridad mejorada

### Próximas Funcionalidades
- 🔄 Notificaciones por email para pagos pendientes
- 🔄 Dashboard financiero avanzado
- 🔄 Reportes de ingresos por período
- 🔄 Sistema de descuentos y promociones
