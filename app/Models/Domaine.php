<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_domaine L'id du domaine
 * @property string $nom_domaine Le nom du domaine
 */
class Domaine extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_domaine';

    public function filieres()
    {
        return $this->hasMany(Filiere::class);
    }
}
