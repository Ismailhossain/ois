<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $table = 'bank_accounts';

    protected $fillable = [
        'financial_organization_id',
        'store_id',
        'account_name',
        'account_no',
        'branch',
        'account_type',
        'swift_code',
        'route_no',
    ];

    public function bank()
    {
        return $this->hasOne(FinancialOrganization::class, 'id','financial_organization_id');
    }
    public function account_type()
    {
        return $this->hasOne(AccountType::class, 'id','account_type');
    }

}
