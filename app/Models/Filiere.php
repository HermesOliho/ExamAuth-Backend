<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_filiere L'ID de la filière
 * @property string $nom_filiere Le nom de la filière
 */
class Filiere extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_filiere';

    protected $fillable = [
        "nom_domaine"
    ];

    public function domaine()
    {
        return $this->belongsTo(Domaine::class);
    }

    public function mentions()
    {
        return $this->hasMany(Mention::class);
    }
}
