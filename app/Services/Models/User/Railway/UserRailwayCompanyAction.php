<?php

namespace App\Services\Models\User\Railway;

use App\Actions\Compta;
use App\Models\User\Railway\UserRailwayCompany;
use App\Models\User\Railway\UserRailwayMouvement;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class UserRailwayCompanyAction
{
    public function __construct(private UserRailwayCompany $company)
    {
    }

    public function getCA(?Carbon $from = null, ?Carbon $to = null)
    {
        return UserRailwayMouvement::where('user_railway_company_id', $this->company->id)
            ->where('type_amount', 'revenue')
            ->whereNot('type_mvm', 'divers')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');
    }

    public function getCoastTravel(?Carbon $from = null, ?Carbon $to = null)
    {
        return UserRailwayMouvement::where('user_railway_company_id', $this->company->id)
            ->where('type_mvm', 'cout_trajet')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');
    }

    public function getResultat(?Carbon $from = null, ?Carbon $to = null)
    {
        $ca = $this->getCA($from, $to);
        $charge = $this->getCoastTravel($from, $to);

        return $ca - $charge;
    }

    public function getRembEmprunt(?Carbon $from = null, ?Carbon $to = null)
    {
        return UserRailwayMouvement::where('user_railway_company_id', $this->company->id)
            ->where('type_mvm', 'pret')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');
    }

    public function getLocationMateriel(?Carbon $from = null, ?Carbon $to = null)
    {
        return UserRailwayMouvement::where('user_railway_company_id', $this->company->id)
            ->where('type_mvm', 'location_materiel')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');
    }

    public function getTresorerieStructurel(?Carbon $from = null, ?Carbon $to = null)
    {
        $maintenance = UserRailwayMouvement::where('user_railway_company_id', $this->company->id)
            ->where('type_mvm', 'maintenance_engine')
            ->orWhere('type_mvm', 'maintenance_technicentre')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');

        $location = $this->getLocationMateriel($from, $to);
        $rembEmprunt = $this->getRembEmprunt($from, $to);
        $impot = UserRailwayMouvement::where('user_railway_company_id', $this->company->id)
            ->where('type_mvm', 'impot')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');
        $revenue = UserRailwayMouvement::where('user_railway_company_id', $this->company->id)
            ->where('type_amount', 'revenue')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');

        return $revenue - ($maintenance + $location + $rembEmprunt + $impot);
    }

    public function getBenefice(?Carbon $from = null, ?Carbon $to = null)
    {
        $billetterie = UserRailwayMouvement::where('user_railway_company_id', $this->company->id)
            ->where('type_mvm', 'billetterie')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');
        $cout = $this->getCoastTravel($from, $to);

        return $billetterie - $cout;
    }

    public function getTotalPassengers(?Carbon $from = null, ?Carbon $to = null)
    {
        $sum = 0;
        foreach (auth()->user()->userRailwayHub as $hub) {
            $plannings = $hub->plannings()
                ->when($from && $to, fn (Builder $query) => $query->whereBetween('date_depart', [$from->startOfDay(), $to->endOfDay()]))
                ->get();

            foreach ($plannings as $planning) {
                foreach ($planning->passengers as $passenger) {
                    $sum += $passenger->nb_passengers;
                }
            }
        }

        return $sum;
    }

    public function getKilometrageTotal()
    {
        $sum = 0;
        foreach (auth()->user()->userRailwayLigne as $ligne) {
            $sum += $ligne->railwayLigne->distance;
        }

        return $sum;
    }
    public function getDistractCoefOfLevel()
    {
        return match ($this->company->distraction) {
            2 => 8,
            3 => 10,
            4 => 13,
            5 => 15,
            default => 5,
        };
    }

    public function getPercentImportOfLatestImpot(int|float $amount)
    {
        if($amount < 0) {
            if ($amount <= -28282828) {
                return $amount * 0 / 100;
            } elseif ($amount >= -28282829 && $amount <= -42714818) {
                return $amount * 1 / 100;
            } elseif ($amount >= -42714819 && $amount <= -64821081) {
                return $amount * 2 / 100;
            } elseif ($amount >= -64821082 && $amount <= -87401726) {
                return $amount * 4 / 100;
            } elseif ($amount >= -87401727 && $amount <= -126290615) {
                return $amount * 6 / 100;
            } elseif ($amount >= -126290616) {
                return $amount * 10 / 100;
            } else {
                return 0;
            }
        } else {
            if ($amount <= 28282828) {
                return $amount * 0 / 100;
            } elseif ($amount >= 28282829 && $amount <= 42714818) {
                return $amount * 1 / 100;
            } elseif ($amount >= 42714819 && $amount <= 64821081) {
                return $amount * 2 / 100;
            } elseif ($amount >= 64821082 && $amount <= 87401726) {
                return $amount * 4 / 100;
            } elseif ($amount >= 87401727 && $amount <= 126290615) {
                return $amount * 6 / 100;
            } elseif ($amount >= 126290616) {
                return $amount * 10 / 100;
            } else {
                return 0;
            }
        }
    }

    public function calcLatestImpot(?Carbon $from = null, ?Carbon $to = null)
    {
        $rent_trajet = $this->company->mouvements()
            ->where('type_mvm', 'billetterie')
            ->where('type_mvm', 'rent_trajet_aux')
            ->when($from && $to, fn(Builder $query) => $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]))
            ->sum('amount');

        $location = $this->getLocationMateriel($from, $to);
        $total = $rent_trajet - $location;
        $amount = $this->getPercentImportOfLatestImpot($total);
        $credit_impot = $this->company->credit_impot;
        $amountTotal = $amount - $credit_impot;

        if($amountTotal <= 0) {
            $this->company->update([
                'credit_impot' => $amountTotal,
            ]);
        } else {
            (new Compta())
                ->create(
                    user: auth()->user(),
                    title: 'Prlv Impot du '.Carbon::today()->format('d/m/Y'),
                    amount: $amountTotal,
                    type_amount: 'charge',
                    type_mvm: 'impot',
                );
            $this->company->update([
                'last_impot' => $amountTotal
            ]);
        }
    }
}
