<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariationType extends Model
{
    protected $fillable = [
        'name',
        'status'
    ];

    public function isActive()
    {
        return $this->status == 1;
    }
}