<?php

namespace App\Models;

use App\Models\BankBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'banks_info';

    protected $fillable = [
        'Id','BankName','BankDescription','ShortName'
    ];

    public function branches(){
        return $this->hasMany(BankBranch::class);
    }
}
