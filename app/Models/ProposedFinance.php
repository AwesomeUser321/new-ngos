<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposedFinance extends Model
{
    use HasFactory;

        protected $table = 'proposed_finances';
        protected $fillable = ['name'];

        public function financialDetails()
    {
        return $this->hasMany(Financial::class, 'prop_finan_id');
    }
}
