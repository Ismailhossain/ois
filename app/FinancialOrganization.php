<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinancialOrganization extends Model
{
    protected $table = 'financial_organizations';

    protected $fillable = [
        'name',
        'short_name',
        'address',
    ];
}
