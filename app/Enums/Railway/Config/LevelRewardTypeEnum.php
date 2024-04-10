<?php

namespace App\Enums\Railway\Config;

enum LevelRewardTypeEnum: string
{
    case ARGENT = 'Argent';
    case TPOINT = 'TPoint';
    case RD_RATE = 'Taux de recherche';
    case RD_COAST = 'App de recherche';
    case AUDIT_INT = 'Audit Interne';
    case AUDIT_EXT = 'Audit Externe';
    case SIMULATION = 'Simulation';
    case IMPOT = 'Crédit Impot';
    case ENGINE = 'Matériel Roulant';
    case ENGINE_R = 'reskin';


    public function getLabel(): string
    {
        return match ($this) {
            self::ARGENT => 'Argent',
            self::TPOINT => 'TPoint',
            self::RD_RATE => 'Taux de recherche',
            self::RD_COAST => 'App de recherche',
            self::AUDIT_INT => 'Audit Interne',
            self::AUDIT_EXT => 'Audit Externe',
            self::SIMULATION => 'Simulation',
            self::IMPOT => 'Crédit Impot',
            self::ENGINE => 'Matériel Roulant',
            self::ENGINE_R => 'reskin',
        };
    }

    public function getValue(): string
    {
        return match ($this) {
            self::ARGENT => 'argent',
            self::TPOINT => 'TPoint',
            self::RD_RATE => 'research_rate',
            self::RD_COAST => 'research_coast',
            self::AUDIT_INT => 'audit_int',
            self::AUDIT_EXT => 'audit_ext',
            self::SIMULATION => 'simulation',
            self::IMPOT => 'credit_impot',
            self::ENGINE => 'engine',
            self::ENGINE_R => 'reskin',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::ARGENT => \Storage::url('icons/railway/argent.png'),
            self::TPOINT => \Storage::url('icons/railway/tpoint.png'),
            self::RD_RATE => \Storage::url('icons/railway/rate_research.png'),
            self::RD_COAST => \Storage::url('icons/railway/research.png'),
            self::AUDIT_INT => \Storage::url('icons/railway/audit_int.png'),
            self::AUDIT_EXT => \Storage::url('icons/railway/audit_ext.png'),
            self::SIMULATION => \Storage::url('icons/railway/simulation.png'),
            self::IMPOT => \Storage::url('icons/railway/credit_impot.png'),
            self::ENGINE => \Storage::url('icons/railway/train.png'),
            self::ENGINE_R => \Storage::url('icons/railway/reskin.png'),
        };
    }
}
