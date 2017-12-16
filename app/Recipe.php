<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Recipe extends Model
{
    //
    use SoftDeletes;


    protected $fillable = [
        'user_id', 'id'
    ];




    protected $dates = ['deleted_at'];


    public function recipes(){
          return $this->belongsTo('App\User');
    }


}
