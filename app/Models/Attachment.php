<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['decree_id', 'file_path', 'description'];

    public function decree()
    {
        return $this->belongsTo(Decree::class);
    }
}

