<?php

namespace App\Data;

class Locations
{
    public static function search(string $query): array
    {
        $locations = self::getLocations();
        return array_filter(
            $locations,
            fn($location) => stripos($location, $query) !== false
        );
    }

    public static function getLocations(): array
    {
        return [
            'YuraiCars - Santo Domingo',
            'YuraiCars - Santiago',
            'YuraiCars - Punta Cana',
            'YuraiCars - Puerto Plata',
            'YuraiCars - La Romana',
            'YuraiCars - Higüey',
            'YuraiCars - San Pedro de Macorís',
            'YuraiCars - San Cristóbal',
            'YuraiCars - San Francisco de Macorís',
            'YuraiCars - Moca',
            'YuraiCars - La Vega',
            'YuraiCars - San Juan de la Maguana',
            'YuraiCars - Barahona',
            'YuraiCars - Azua',
            'YuraiCars - Bonao',
            'YuraiCars - San José de Ocoa',
            'YuraiCars - Baní',
            'YuraiCars - Monte Plata',
            'YuraiCars - Hato Mayor',
            'YuraiCars - El Seibo',
            'YuraiCars - Nagua',
            'YuraiCars - Samaná',
            'YuraiCars - Montecristi',
            'YuraiCars - Dajabón',
            'YuraiCars - Mao',
            'YuraiCars - San Ignacio de Sabaneta',
            'YuraiCars - San Juan de la Maguana',
            'YuraiCars - Neiba',
            'YuraiCars - Jimaní',
            'YuraiCars - Pedernales',
            'YuraiCars - Comendador',
            'YuraiCars - Bánica',
            'YuraiCars - Restauración',
            'YuraiCars - Loma de Cabrera',
            'YuraiCars - Partido',
            'YuraiCars - Villa Vásquez',
            'YuraiCars - Castañuelas',
            'YuraiCars - Guayubín',
            'YuraiCars - Las Matas de Santa Cruz',
            'YuraiCars - Villa Tapia',
            'YuraiCars - Salcedo',
            'YuraiCars - Tenares',
            'YuraiCars - Castillo',
            'YuraiCars - Villa Riva',
            'YuraiCars - Pimentel',
            'YuraiCars - Cotuí',
            'YuraiCars - Fantino',
            'YuraiCars - La Mata',
            'YuraiCars - Cevicos',
            'YuraiCars - Villa Altagracia',
            'YuraiCars - San Gregorio de Nigua',
            'YuraiCars - Yaguate',
            'YuraiCars - Cambita Garabitos',
            'YuraiCars - Los Cacaos',
            'YuraiCars - Sabana Grande de Palenque',
            'YuraiCars - Bajos de Haina',
            'YuraiCars - San Gregorio de Yaguate',
            'YuraiCars - Guerra',
            'YuraiCars - Boca Chica',
            'YuraiCars - San Antonio de Guerra',
            'YuraiCars - Los Alcarrizos',
            'YuraiCars - Pedro Brand',
            'YuraiCars - Santo Domingo Este',
            'YuraiCars - Santo Domingo Norte',
            'YuraiCars - Santo Domingo Oeste',
            'YuraiCars - Distrito Nacional',
        ];
    }
} 