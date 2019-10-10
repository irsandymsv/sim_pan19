<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lemari extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */

    protected $guarded = ['id'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lemari';

    public function SuratMasuk()
    {
        return $this->hasMany('App\SuratMasuk');
    }

    public function SuratKeluar()
    {
        return $this->hasMany('App\SuratKeluar');
    }
}
