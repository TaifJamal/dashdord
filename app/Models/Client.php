<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=['name_ar','name_en','image'];

    public function portfolioDetailes()
    {
        return $this->hasMany(PortfolioDetaile::class);
    }
}
