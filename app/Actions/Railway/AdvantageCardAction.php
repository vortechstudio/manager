<?php

namespace App\Actions\Railway;

use App\Models\Railway\Config\RailwayAdvantageCard;
use App\Models\Railway\Engine\RailwayEngine;

class AdvantageCardAction extends AdvantageDropRate
{
    public function generate(): void
    {
        foreach (RailwayAdvantageCard::all() as $card) {
            $card->delete();
        }

        // TODO: ajouter la prise en charge de model_id pour les reskins lorsque le développement est terminer
        for ($i = 0; $i <= 250; $i++) {
            $class = $this->generateClass();
            $type = $this->generateType();
            $qte = $this->generateQteFromTypeAndClass($type, $class);
            $coast = $this->defineCoastFromClass($class);
            RailwayAdvantageCard::create([
                'class' => $class,
                'type' => $type,
                'description' => $this->defineDescriptionFromType($type, $qte),
                'qte' => $qte,
                'tpoint' => $coast,
                'drop_rate' => $this->calculateDropRateByType($qte, $type),
            ]);
        }
    }

    public function generateClass(): string
    {
        $classes = collect(['premium', 'first', 'second', 'first']);
        return $classes->random();
    }

    public function generateType(): string
    {
        $types = collect(['argent', 'research_rate', 'research_coast', 'audit_int', 'audit_ext', 'simulation', 'credit_impot', 'engine', 'reskin']);
        return $types->random();
    }

    public function generateQteFromTypeAndClass(string $type, string $class): float|int
    {
        return match ($class) {
            'premium' => self::generateQteFromType($type) * ($type == 'engine' || $type == 'reskin' ? 1 : 10),
            'first' => self::generateQteFromType($type) * ($type == 'engine' || $type == 'reskin' ? 1 : 5),
            'second' => self::generateQteFromType($type) * ($type == 'engine' || $type == 'reskin' ? 1 : 2),
            'third' => self::generateQteFromType($type),
            default => 0,
        };
    }

    public function generateQteFromType(string $type): float|int
    {
        return match ($type) {
            'argent', 'credit_impot', 'research_coast' => round(random_int(100000, 1000000), -3, PHP_ROUND_HALF_UP),
            'research_rate' => round(generateRandomFloat(0.05, 0.20), 2, PHP_ROUND_HALF_UP),
            'audit_int', 'audit_ext', 'simulation' => random_int(1, 10),
            'engine', 'reskin' => 1,
            default => 0,
        };
    }

    public function defineCoastFromClass(string $class): int
    {
        return match ($class) {
            'premium' => 50,
            'first' => 25,
            'second' => 15,
            default => 0,
        };
    }

    private function defineDescriptionFromType(string $type, int $qte): string
    {
        if ($type == 'engine' || $type == 'reskin') {
            $motor = RailwayEngine::all()->random();
        } else {
            $motor = null;
        }

        return match ($type) {
            'argent' => '+ '.number_format($qte, 0, ',', ' ').' €',
            'research_rate' => 'Taux R&D + '.$qte.'%',
            'research_coast' => 'Budget R&D + '.number_format($qte, 0, ',', ' ').' €',
            'audit_int' => number_format($qte, 0, ',', ' ').' audit interne',
            'audit_ext' => number_format($qte, 0, ',', ' ').' audit externe',
            'simulation' => number_format($qte, 0, ',', ' ').' simulation',
            'credit_impot' => 'Impôt - '.number_format($qte, 0, ',', ' ').' €',
            'engine' => $motor->name,
            'reskin' => 'Reskin de '.$motor->name,
            default => 'Erreur',
        };
    }

    private function calculateDropRateByType(int $qte, string $type)
    {
        return match ($type) {
            'argent' => $this->rateArgent($qte),
            'research_rate' => $this->rateResearchRate($qte),
            'research_coast' => $this->rateResearchCoast($qte),
            'audit_int' => $this->rateAuditInt($qte),
            'audit_ext' => $this->rateAuditExt($qte),
            'simulation' => $this->rateSimulation($qte),
            'credit_impot' => $this->rateCreditImpot($qte),
            'engine', 'reskin' => 5.0,
            default => 0,
        };
    }
}
