<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableOrders extends Model
{
    use HasFactory;
    protected $fillable = ['table','product_id'];
}
