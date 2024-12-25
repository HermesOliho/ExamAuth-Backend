<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_tranche
 * @property string $semestre
 * @property float $montant
 * @property string $echeance_paiement
 */
class FraisAcademiques extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_tranche';

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, "promotions_frais_academiques");
    }
}
