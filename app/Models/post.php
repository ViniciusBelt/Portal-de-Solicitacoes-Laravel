<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'caixaEntrada';

    protected $guarded = [];
    public function etapa(){
        return $this->hasOne(Etapas::class, 'id', 'id_etapa'); 
    }
}