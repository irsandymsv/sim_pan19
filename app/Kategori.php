<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
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
    protected $table = 'kategori';

    public function SuratMasuk()
    {
        return $this->hasMany('App\SuratMasuk');
    }
}
