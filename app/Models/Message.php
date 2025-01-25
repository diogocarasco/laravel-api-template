<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * Desabilita o auto-incremento para a chave primária.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Define o tipo da chave primária como string.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Os atributos que podem ser preenchidos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'text1',
        'text2',
        'text3',
        'date',
    ];
}
