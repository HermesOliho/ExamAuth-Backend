<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_etudiant L'ID de l'étudiant
 * @property string $nom Le nom de l'étudiant
 * @property string $post_nom Le post-nom de l'étudiant
 * @property string|null $prenom Le prénom de l'étudiant
 * @property "M"|"F" $sexe Le sexe de l'étudiant
 * @property string $matricule Le matricule de l'étudiant
 * @property string $adresse L'adresse de l'étudiant
 * @property string $lieu_naissance Le lieu de naissance de l'étudiant
 * @property string $date_naissance La date de naissance de l'étudiant
 * @property string $image_url Lien vers la photo de l'étudiant
 */
class Etudiant extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_etudiant';

    protected $fillable = [
        "nom",
        "post_nom",
        "prenom",
        "sexe",
        "matricule",
        "adresse",
        "lieu_naissance",
        "date_naissance",
        "image_url",
        // "id_promotion",
        // "annee_academique"
    ];

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    public function derogations()
    {
        return $this->hasMany(Derogation::class);
    }
}
