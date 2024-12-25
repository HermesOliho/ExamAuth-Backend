<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $annee_academique
 */
class Inscription extends Model
{
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
}
