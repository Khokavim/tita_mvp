<?php

namespace tita;

use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    //
    protected $fillable=['sell_id','track_id','seller_id','buyer_id','quantity','bid','asset','verified','sold']; 

}
