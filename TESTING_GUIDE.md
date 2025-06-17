# 🧪 Guía Completa de Testing - YuraiCars

Esta guía te explica cómo usar el sistema completo de pruebas que hemos implementado para tu aplicación de alquiler de autos.

## 📋 Índice

1. [Tipos de Pruebas Implementadas](#tipos-de-pruebas)
2. [Cómo Ejecutar las Pruebas](#ejecución)
3. [Explicación Detallada](#explicación-detallada)
4. [Comandos Útiles](#comandos-útiles)
5. [Interpretación de Resultados](#resultados)
6. [Troubleshooting](#troubleshooting)

## 🎯 Tipos de Pruebas Implementadas {#tipos-de-pruebas}

### 1. **Pruebas Unitarias** 📐
- **Archivo**: `tests/Unit/PaymentServiceTest.php`
- **Propósito**: Probar funciones específicas de cálculo y validación
- **Qué prueba**: 
  - Validación de datos de tarjetas de crédito
  - Algoritmos de validación (formato de fecha, CVV, nombres)
  - Funciones de cálculo del servicio de pagos

### 2. **Pruebas de Humo (Smoke Tests)** 💨
- **Archivo**: `tests/Feature/SmokeTest.php`
- **Propósito**: Verificar que las funcionalidades básicas funcionen
- **Qué prueba**:
  - Páginas principales cargan correctamente
  - Base de datos se conecta
  - Servicios esenciales están disponibles
  - Rutas protegidas funcionan correctamente

### 3. **Pruebas de API** 🌐
- **Archivo**: `tests/Feature/ApiTest.php`
- **Propósito**: Probar endpoints y respuestas HTTP
- **Qué prueba**:
  - Formularios procesan datos correctamente
  - Validaciones funcionan
  - Autenticación y autorización
  - Headers de respuesta son correctos

### 4. **Pruebas de Integración** 🔗
- **Archivo**: `tests/Feature/IntegrationTest.php`
- **Propósito**: Verificar flujos completos del sistema
- **Qué prueba**:
  - Registro completo de usuarios
  - Flujo de autenticación
  - Procesos de pago de extremo a extremo
  - Navegación entre páginas

### 5. **Pruebas de Caja Blanca** 🔍
- **Archivo**: `tests/Unit/WhiteBoxTest.php`
- **Propósito**: Analizar estructura interna y cobertura de código
- **Qué prueba**:
  - Todas las ramas de código
  - Condiciones límite
  - Complejidad ciclomática
  - Flujos de control internos

### 6. **Pruebas de Estrés** ⚡
- **Archivo**: `tests/Feature/StressTest.php`
- **Propósito**: Evaluar rendimiento y capacidad de carga
- **Qué prueba**:
  - Carga de usuarios concurrentes
  - Procesamiento masivo de pagos
  - Uso de memoria y recursos
  - Resistencia del sistema

## 🚀 Cómo Ejecutar las Pruebas {#ejecución}

### Opción 1: Ejecutar TODAS las pruebas (Recomendado)
```bash
# Hacer el script ejecutable
chmod +x run-tests.sh

# Ejecutar todas las pruebas
./run-tests.sh
```

### Opción 2: Ejecutar por tipo específico
```bash
# Solo pruebas unitarias
./vendor/bin/phpunit tests/Unit/

# Solo pruebas de funcionalidad (API, Integración, etc.)
./vendor/bin/phpunit tests/Feature/

# Solo pruebas de estrés
./vendor/bin/phpunit --group stress

# Una clase específica
./vendor/bin/phpunit tests/Unit/PaymentServiceTest.php
```

### Opción 3: Con opciones adicionales
```bash
# Con más detalles
./vendor/bin/phpunit --verbose

# Con cobertura de código (requiere Xdebug)
./vendor/bin/phpunit --coverage-html coverage-report

# Detener en el primer fallo
./vendor/bin/phpunit --stop-on-failure
```

## 📖 Explicación Detallada {#explicación-detallada}

### Pruebas Unitarias - PaymentService

Estas pruebas verifican cada función individual del servicio de pagos:

- **Validación de tarjetas**: Números válidos/inválidos, longitud correcta
- **Fechas de expiración**: Formato MM/YY correcto
- **CVV**: 3-4 dígitos numéricos
- **Nombres**: No vacíos, longitud mínima
- **Escenarios de fallo**: Tarjetas declinadas, fondos insuficientes

### Pruebas de Humo

Verifican que lo básico funcione sin profundizar:

- ✅ Página principal carga
- ✅ Usuarios pueden ver vehículos
- ✅ Formularios básicos funcionan
- ✅ Base de datos responde
- ✅ Servicios se resuelven correctamente

### Pruebas de API

Prueban todos los endpoints de tu aplicación:

- **GET /vehicles**: Lista de vehículos
- **POST /contact**: Formulario de contacto
- **POST /sign-in**: Login de usuarios
- **POST /sign-up**: Registro de usuarios
- **Validaciones**: Campos requeridos, formatos de email

### Pruebas de Integración

Flujos completos de usuario real:

1. **Registro → Login → Navegación → Logout**
2. **Explorar vehículos → Ver detalles → Dejar reseña**
3. **Proceso de pago completo con diferentes escenarios**
4. **Manejo de errores y validaciones**

### Pruebas de Caja Blanca

Analizan el código internamente:

- **Cobertura de ramas**: Cada `if/else` probado
- **Condiciones límite**: Valores mínimos y máximos
- **Paths independientes**: Diferentes caminos de ejecución
- **Complejidad ciclomática**: Mide la complejidad del código

### Pruebas de Estrés

Evalúan límites y rendimiento:

- **100 usuarios simultáneos**: Login concurrente
- **50 pagos masivos**: Procesamiento en lote
- **500 consultas DB**: Carga en base de datos
- **100 requests HTTP**: Carga web
- **Uso de memoria**: Límites de recursos

## 🛠️ Comandos Útiles {#comandos-útiles}

```bash
# Ver solo pruebas que fallan
./vendor/bin/phpunit --verbose --stop-on-failure

# Ejecutar una prueba específica
./vendor/bin/phpunit --filter test_validates_valid_card_data

# Ver estadísticas de tiempo
./vendor/bin/phpunit --verbose --debug

# Generar reporte de cobertura
./vendor/bin/phpunit --coverage-text

# Ejecutar en paralelo (más rápido)
./vendor/bin/phpunit --parallel
```

## 📊 Interpretación de Resultados {#resultados}

### Símbolos en el Output:
- ✅ **OK**: Prueba pasó exitosamente
- ❌ **FAIL**: Prueba falló - requiere atención
- ⚠️ **SKIP**: Prueba omitida (ej: por dependencias faltantes)
- 🔄 **INCOMPLETE**: Prueba no terminada

### Métricas Importantes:

**Para Pruebas de Estrés:**
- Tiempo de respuesta < 500ms (bueno)
- 95%+ de operaciones exitosas (excelente)
- Uso de memoria < 100MB (aceptable)

**Para Cobertura de Código:**
- \>80% cobertura (buena)
- \>90% cobertura (excelente)
- 100% cobertura (ideal)

### Cuándo Preocuparse:

🚨 **Fallas críticas:**
- Pruebas de humo fallan
- Autenticación no funciona
- Servicios básicos fallan

⚠️ **Fallas de atención:**
- Pruebas de estrés muestran tiempos altos
- Cobertura de código < 70%
- Validaciones inconsistentes

## 🔧 Troubleshooting {#troubleshooting}

### Problema: "Class not found"
```bash
# Regenerar autoload
composer dump-autoload
```

### Problema: "Database connection failed"
```bash
# Verificar configuración de testing
php artisan config:clear
cp .env.example .env.testing
```

### Problema: Pruebas de estrés muy lentas
```bash
# Ejecutar solo las rápidas
./vendor/bin/phpunit tests/Feature/StressTest.php --filter "test_memory_and_resource_usage"
```

### Problema: "Memory limit exceeded"
```bash
# Aumentar límite de memoria
php -d memory_limit=512M ./vendor/bin/phpunit
```

### Problema: Xdebug no disponible para cobertura
```bash
# Instalar Xdebug (Ubuntu/Debian)
sudo apt-get install php-xdebug

# Verificar instalación
php -m | grep xdebug
```

## 📈 Mejores Prácticas

1. **Ejecuta las pruebas antes de cada commit**
2. **Revisa la cobertura de código regularmente**
3. **Las pruebas de estrés úsalas antes de despliegues importantes**
4. **Mantén las pruebas unitarias rápidas (< 100ms cada una)**
5. **Actualiza las pruebas cuando cambies funcionalidad**

## 🎯 Próximos Pasos

Después de ejecutar estas pruebas, puedes:

1. **Agregar más casos de prueba** específicos para tu negocio
2. **Implementar pruebas de seguridad** (SQL injection, XSS)
3. **Configurar CI/CD** para ejecutar pruebas automáticamente
4. **Agregar pruebas de interfaz** con herramientas como Selenium
5. **Monitorear métricas** de rendimiento en producción

---

**¡Felicitaciones!** 🎉 Ahora tienes un sistema completo de pruebas para tu aplicación YuraiCars. Esto te ayudará a mantener la calidad y detectar problemas antes de que lleguen a producción. 