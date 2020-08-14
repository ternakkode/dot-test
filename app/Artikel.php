<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'artikel';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_artikel';

    public function kategori()
    {
        return $this->belongsToMany('App\Kategori', 'artikel_kategori', 'id_artikel', 'kode_kategori');
    }
}
