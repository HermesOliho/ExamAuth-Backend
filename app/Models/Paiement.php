<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $montant Le montant de la transaction
 * @property string $num_bordereau Le numéro du bordereau
 * @property string $date_paiement
 */
class Paiement extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_paiement';

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}
