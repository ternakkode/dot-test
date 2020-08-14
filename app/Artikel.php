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
    protected $hidden = ['updated_at', 'pivot'];

    public function kategori()
    {
        return $this->belongsToMany('App\Kategori', 'artikel_kategori', 'id_artikel', 'kode_kategori');
    }

    public function getHeadlineAttribute($value)
    {
        return url('/'.$value);
    }

    public function getPotonganIsiAttribute($value)
    {
        return substr($this->isi, 3, 50);
    }

    public function getKategoriListAttribute(){
        return $this->kategori;
    }
}
