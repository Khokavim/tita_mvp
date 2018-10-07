<?php

namespace tita\Http\Controllers;

use Illuminate\Http\Request;
use tita\Buy;
use tita\Sell;
use tita\User;

class TransactionsController extends Controller
{
    //
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $confirms=Buy::where('verified','=',1)->where('buyer_id','=',auth()->id())->simplePaginate(3);
        return view('confirm', compact('confirms'));
    }

    public function process(){
        $seller_id=\DB::table('sells')->where('track_id',request('track_id'))->value('seller_id');
        if(Buy::find(\DB::table('buys')->where('verified','=',0)->where('track_id',request('track_id'))->value('id')) != null){
          $id=Buy::findORFail(\DB::table('buys')->where('verified','=',0)->where('track_id',request('track_id'))->value('id'));
        }
        else {
          session()->flash('message','Your are not authorised to confirm this delivery');
          return redirect()->back();
        }
        $id=Buy::findORFail(\DB::table('buys')->where('verified','=',0)->where('track_id',request('track_id'))->value('id'));
        $buy=Buy::where('id','=',$id->id)->first();
        $buy->verified=1;

        $user=User::where('id','=',auth()->id())->first();
        if($user->tita - $buy->quantity * $buy->bid >= 0 && $buy->sold == 1 && $buy->buyer_id == auth()->id()){
          $buy->save();
          $user->tita=$user->tita - $buy->quantity * $buy->bid;
          $user->save();

          $seller=User::where('id','=',$seller_id)->first();
          $seller->tita=$seller->tita + $buy->quantity * $buy->bid;
          $seller->save();

          session()->flash('message','Asset Delivery confirmed');
          return redirect()->back();
        }
        elseif ($buy->buyer_id == auth()->id() && $buy->sold == 0) {
          session()->flash('message','Your buy order has not been approved yet');
          return redirect()->back();
        }
        elseif($buy->buyer_id != auth()->id() ) {
          session()->flash('message','Your are not authorised to confirm this delivery');
          return redirect()->back();
        }
        else{
          session()->flash('message','You do not have enough TITA to confirm this delivery');
          return redirect()->back();
        }

    }
}
