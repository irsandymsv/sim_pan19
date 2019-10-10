<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratKeluar extends Model
{
    use SoftDeletes;
    
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
    protected $table = 'surat_keluar';
    
    protected $casts = [
        'file_surat' => 'array'
    ];

    public function kategori()
    {
    	return $this->belongsTo('App\Kategori');
    }

    public function lemari()
    {
    	return $this->belongsTo('App\Lemari');
    }

    public function operator()
    {
    	return $this->belongsTo('App\User');
    }
}
