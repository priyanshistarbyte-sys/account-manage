<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
       'email',
       'password',
       'category',
       'note',
       'created_by'
    ];

    public function category_name()
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }
    
}
