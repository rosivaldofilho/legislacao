<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Decree extends Model
{
    use HasFactory, SoftDeletes;

    // Atributos que podem ser atribuídos em massa
    protected $fillable = [
        'number',          // Número do decreto
        'doe_number',          // Número do decreto
        'effective_date',  // Data de Publicação
        'summary',         // Ementa
        'content',         // Conteúdo
        'file_pdf',         // Arquivo PDF
        'user_id',         // ID do usuário que criou o decreto
    ];

    protected $casts = [
        'effective_date' => 'datetime', // Define effective_date como timestamp
        'doe_numbers' => 'array',
    ];

    // Define a relação com o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Se você estiver usando anexos, pode adicionar um método para lidar com eles
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    // Exemplo: Para formatar a data de publicação
    public function getEffectiveDateFormatBr()
    {
        return $this->effective_date->format('d/m/Y');
    }
}
