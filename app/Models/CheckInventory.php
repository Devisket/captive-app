<?php

namespace App\Models;

use App\Models\FormCheck;
use App\Models\BankBranch;
use App\Models\CheckOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CheckInventory extends Model
{
    use HasFactory;

    protected $table = 'check_inventory';

    protected $fillable = [
        'Id',
        'StarSeries',
        'EndSeries',
        'Quantity',
        'CheckOrderId',
        'FormCheckId',
        'BranchId',
    ];

    public function branch()
    {
        return $this->belongsTo(BankBranch::class, 'BranchId', 'Id');
    }

    public function formCheck(){
        return $this->belongsTo(FormCheck::class, 'FormCheckId');
    }

    public function checkOrder(){
        return $this->belongsTo(CheckOrder::class, 'CheckOrderId');
    }
}
