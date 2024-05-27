<?php

namespace App\Models;

use App\Models\Bank;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormCheck extends Model
{
    use HasFactory;

    protected $table = 'form_checks';

    protected $fillable = [
        'Id','BankId',
        'CheckType',
        'FormType',
        'Description',
        'Quantity',
        'ProductTypeId',
        'FileInitial',
    ];

    public function bank(){
        return $this->belongsTo(Bank::class, 'BankId',"Id");
    }
}
