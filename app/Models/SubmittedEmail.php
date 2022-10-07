<?php

namespace App\Models;

use Database\Factories\SubmittedEmailFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmittedEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
    ];

    protected static function newFactory()
    {
        return SubmittedEmailFactory::new();
    }
}
