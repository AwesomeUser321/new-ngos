<?php

namespace App\Models;

use CreateBanksTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    use HasFactory;

    protected $table = 'financials';
    protected $fillable = [
        'has_bank_account',
        'bank_id',
        'branch_name',
        'branch_code',
        'income_expenditure_file',
        'prop_finan_id',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function proposedFinance()
    {
        return $this->belongsTo(ProposedFinance::class, 'prop_finan_id');
    }
}
