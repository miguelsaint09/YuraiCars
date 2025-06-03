<?php

namespace App\Enums;

enum VehicleFeatures: string
{
    case GPS = 'Navegación GPS';
    case BLUETOOTH = 'Bluetooth';
    case BACKUP_CAMERA = 'Cámara de Retroceso';
    case CRUISE_CONTROL = 'Control de Crucero';
    case CLIMATE_CONTROL = 'Control de Clima';
    case LEATHER_SEATS = 'Asientos de Cuero';
    case SUNROOF = 'Techo Solar';
    case PARKING_SENSORS = 'Sensores de Estacionamiento';
    case KEYLESS_ENTRY = 'Entrada sin Llave';
    case APPLE_CARPLAY = 'Apple CarPlay';
    case ANDROID_AUTO = 'Android Auto';
    case WIFI = 'Wi-Fi';
    case USB_PORTS = 'Puertos USB';
    case HEATED_SEATS = 'Asientos Calefactados';
    case BLIND_SPOT = 'Monitor de Punto Ciego';
    case LANE_ASSIST = 'Asistente de Carril';

    /**
     * @return array<string, string>
     */
    public static function values(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_column(self::cases(), 'name')
        );
    }
}