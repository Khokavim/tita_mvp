<?php

namespace tita;

use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    //
    protected $fillable=['sell','track_id','seller_id','quantity','bid','asset','verified','sold'];

}
