<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $motif
 * @property string $date_debut
 * @property string $date_fin
 */
class Derogation extends Model
{
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}
