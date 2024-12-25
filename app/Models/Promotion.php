<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** 
 * @property int $id_promotion L'ID de la promotion
 * @property string $nom_promotion Le nom de la promotion
 */
class Promotion extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_promotion';

    protected $fillable = [
        "nom_promotion"
    ];

    public function mention()
    {
        return $this->belongsTo(Mention::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function frais_academiques()
    {
        return $this->belongsToMany(FraisAcademiques::class, "promotions_frais_academiques");
    }
}
