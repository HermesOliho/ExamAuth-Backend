<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_mention L'ID de la mention
 * @property string $nom_mention La désignation de la mention
 */
class Mention extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_mention';

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }
}
