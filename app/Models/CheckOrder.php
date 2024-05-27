<?php

namespace App\Models;

use App\Models\FormCheck;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CheckOrder extends Model
{
    use HasFactory;

    protected $table = 'check_orders';

    protected $fillable = [
        'Id',
        'AccountNo',
        'OrderFileId',
        'FormCheckId',
        'BRSTN',
        'AccountName',
        'Concode',
        'OrderQuanity',
        'DeliverTo',
    ];

    public function formCheck(){
        return $this->belongsTo(FormCheck::class, 'FormCheckId');

    }
}
