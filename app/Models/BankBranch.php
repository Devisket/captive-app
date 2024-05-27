<?php

namespace App\Models;

use App\Models\Bank;
use App\Models\CheckInventory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankBranch extends Model
{
    use HasFactory;

    protected $table = 'bank_branchs';

    protected $fillable = [
        'Id','BankId',
        'BranchName',
        'BranchAddress1',
        'BranchAddress2',
        'BranchAddress3',
        'BranchAddress4',
        'BranchAddress5',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'BankId', 'Id');
    }

    public function checkInventories(){
        return $this->hasMany(CheckInventory::class);
    }
}
