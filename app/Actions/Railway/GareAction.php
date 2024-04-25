<?php

namespace App\Actions\Railway;

class GareAction
{
    public function getHabitant(string $type_gare, int $freq): int
    {
        return match ($type_gare) {
            'halte' => intval($freq * 1.2),
            'small' => intval($freq * 1.8),
            'medium' => intval($freq * 2.6),
            'large' => intval($freq * 4.5),
            'terminus' => intval($freq * 5.6),
        };
    }

    public function defineEquipements(string $type_gare): array
    {
        return match ($type_gare) {
            'halte' => ['info_visuel'],
            'small' => ['info_visuel', 'toilette', 'info_sonore'],
            'medium' => ['info_visuel', 'toilette', 'info_sonore', 'guichets'],
            'large', 'terminus' => ['toilette', 'info_visuel', 'info_sonore', 'guichets', 'ascenceurs', 'escalator', 'boutique', 'restaurant'],
        };
    }

    public function definePrice($type_gare, $nb_quai): float
    {
        $coef = match ($type_gare) {
            'halte' => 1.05,
            'small' => 1.20,
            'medium' => 1.80,
            'large' => 2.30,
            'terminus' => 3,
        };

        $price_base = match ($type_gare) {
            'halte' => 25000,
            'small' => 47000,
            'medium' => 78000,
            'large' => 195000,
            'terminus' => 270000,
        };

        $calc = ($price_base * $coef) * $nb_quai;

        return round($calc, 2);
    }

    public static function defineTaxeHub($price, $nb_quai): float
    {
        $calc = $price / $nb_quai / 20 / 10;

        return round($calc, 2);
    }
}
