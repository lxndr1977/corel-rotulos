<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name'
    ];

    public function batches() {
        return $this->hasMany(Batch::class, 'supplier_id', 'id');
    }
}
