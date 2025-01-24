<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaOfOperation extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }
}
