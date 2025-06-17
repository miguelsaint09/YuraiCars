#!/bin/bash

# Script para ejecutar todas las pruebas de YuraiCars
# Autor: Asistente de Testing
# Fecha: $(date)

echo "🚗 SISTEMA DE PRUEBAS COMPLETO - YURAI CARS 🚗"
echo "=============================================="
echo ""

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Función para mostrar headers
show_header() {
    echo -e "${BLUE}================================${NC}"
    echo -e "${BLUE}$1${NC}"
    echo -e "${BLUE}================================${NC}"
    echo ""
}

# Función para mostrar resultados
show_result() {
    if [ $1 -eq 0 ]; then
        echo -e "${GREEN}✅ $2 - EXITOSO${NC}"
    else
        echo -e "${RED}❌ $2 - FALLIDO${NC}"
    fi
    echo ""
}

# Verificar que estamos en un proyecto Laravel
if [ ! -f "artisan" ]; then
    echo -e "${RED}❌ Error: No se encontró el archivo artisan. Asegúrate de estar en el directorio raíz del proyecto Laravel.${NC}"
    exit 1
fi

# Verificar que PHPUnit está disponible
if [ ! -f "vendor/bin/phpunit" ]; then
    echo -e "${YELLOW}⚠️  PHPUnit no encontrado. Instalando dependencias...${NC}"
    composer install
fi

echo -e "${GREEN}🎯 Iniciando suite completa de pruebas...${NC}"
echo ""

# 1. PRUEBAS UNITARIAS
show_header "1. PRUEBAS UNITARIAS (Funciones de Cálculo)"
echo "Ejecutando pruebas de funciones específicas y cálculos..."
./vendor/bin/phpunit tests/Unit/PaymentServiceTest.php
show_result $? "Pruebas Unitarias - PaymentService"

# 2. PRUEBAS DE HUMO
show_header "2. PRUEBAS DE HUMO (Smoke Tests)"
echo "Verificando que las funcionalidades básicas funcionen..."
./vendor/bin/phpunit tests/Feature/SmokeTest.php
show_result $? "Pruebas de Humo"

# 3. PRUEBAS DE API
show_header "3. PRUEBAS DE API"
echo "Probando endpoints y respuestas de la API..."
./vendor/bin/phpunit tests/Feature/SimpleApiTest.php
show_result $? "Pruebas de API"

# 4. PRUEBAS DE INTEGRACIÓN
show_header "4. PRUEBAS DE INTEGRACIÓN"
echo "Ejecutando flujos completos end-to-end..."
./vendor/bin/phpunit tests/Feature/SimpleIntegrationTest.php
show_result $? "Pruebas de Integración"

# 5. PRUEBAS DE CAJA BLANCA
show_header "5. PRUEBAS DE CAJA BLANCA (White Box)"
echo "Analizando estructura interna y cobertura de código..."
./vendor/bin/phpunit tests/Unit/WhiteBoxTest.php
show_result $? "Pruebas de Caja Blanca"

# 6. PRUEBAS DE ESTRÉS
show_header "6. PRUEBAS DE ESTRÉS (Stress Tests)"
echo "⚠️  Las pruebas de estrés pueden tardar varios minutos..."
echo "Evaluando rendimiento y capacidad de carga..."
./vendor/bin/phpunit tests/Feature/SimpleStressTest.php
show_result $? "Pruebas de Estrés"

# RESUMEN FINAL
echo ""
show_header "📊 RESUMEN DE EJECUCIÓN"
echo -e "${BLUE}Todas las pruebas han sido ejecutadas.${NC}"
echo ""

# Ejecutar todas las pruebas y generar reporte de cobertura (opcional)
if command -v xdebug &> /dev/null; then
    echo -e "${YELLOW}🔍 Generando reporte de cobertura de código...${NC}"
    ./vendor/bin/phpunit --coverage-html coverage-report
    echo -e "${GREEN}✅ Reporte de cobertura generado en: coverage-report/index.html${NC}"
    echo ""
fi

# Estadísticas finales
echo -e "${BLUE}📈 ESTADÍSTICAS FINALES:${NC}"
echo "- Pruebas Unitarias: Funciones de cálculo y validaciones"
echo "- Pruebas de Humo: Verificación básica de funcionalidad"
echo "- Pruebas de API: Endpoints y respuestas HTTP"
echo "- Pruebas de Integración: Flujos completos del sistema"
echo "- Pruebas de Caja Blanca: Cobertura interna de código"
echo "- Pruebas de Estrés: Rendimiento y capacidad de carga"
echo ""

echo -e "${GREEN}🎉 ¡Suite de pruebas completada!${NC}"
echo -e "${BLUE}Para ejecutar tipos específicos de pruebas, usa:${NC}"
echo "  - Solo unitarias: ./vendor/bin/phpunit tests/Unit/"
echo "  - Solo de funcionalidad: ./vendor/bin/phpunit tests/Feature/"
echo "  - Solo de estrés: ./vendor/bin/phpunit --group stress"
echo "" 