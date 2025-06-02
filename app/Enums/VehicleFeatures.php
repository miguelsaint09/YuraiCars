<?php

namespace App\Enums;

enum VehicleFeatures: string
{
    case GPS = 'GPS Navigation';
    case BLUETOOTH = 'Bluetooth';
    case BACKUP_CAMERA = 'Backup Camera';
    case CRUISE_CONTROL = 'Cruise Control';
    case CLIMATE_CONTROL = 'Climate Control';
    case LEATHER_SEATS = 'Leather Seats';
    case SUNROOF = 'Sunroof';
    case PARKING_SENSORS = 'Parking Sensors';
    case KEYLESS_ENTRY = 'Keyless Entry';
    case APPLE_CARPLAY = 'Apple CarPlay';
    case ANDROID_AUTO = 'Android Auto';
    case WIFI = 'Wi-Fi Hotspot';
    case USB_PORTS = 'USB Ports';
    case HEATED_SEATS = 'Heated Seats';
    case BLIND_SPOT = 'Blind Spot Monitor';
    case LANE_ASSIST = 'Lane Departure Assist';

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