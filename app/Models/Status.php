<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['content'];

    //status-user relationship
    public function user(){
        return $this->belongsTo(User::class);
    }
}
