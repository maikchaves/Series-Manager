<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    //define o que será preenchido automaticamente usando mass assignment
    protected $fillable = ['name'];



    public function seasons()
    {
        //o segundo parâmetros indica uma chave estrangeiro, caso não seja o padrão do laravel (que seria serie_id, em portugues)
        return $this->hasMany(Season::class, 'series_id');
    }

    protected static function booted()
    {
        self::addGlobalScope('', function (Builder $queryBuilder) {
            $queryBuilder->orderBy('name');
        });
    }
}
