<?php

namespace tita\Http\Controllers;

use Illuminate\Http\Request;
use tita\Buy;
use tita\Sell;
use tita\User;


class SellController extends Controller
{
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
      $bids=Buy::where('seller_id','=',auth()->id())->simplePaginate(3);
      return view('sell', compact('bids'));
    }

    public function sell(Request $request){
      $this->validate($request, [
        'asset' => 'required|string',
        'quantity' => 'string|required',
        'bid' => 'string|required'
      ]);

      $sell=Sell::create([
        'sell_id'=> request('buyid'),
        'track_id'=> '#TITA456'.rand(1,99999),
        'seller_id'=> auth()->id(),
        'quantity'=> request('quantity'),
        'bid'=> request('bid'),
        'asset'=> request('asset'),
        'verified'=>0,
        'sold'=>0
      ]);

      session()->flash('message','Asset created successfuly '.$sell->track_id);
      return redirect()->back();
    }

    public function process($id){
      if(Sell::find(Buy::find($id)->sell_id)->quantity - Buy::find($id)->quantity >= 0){
        $buyer=Buy::find($id);
        $seller=Sell::find($buyer->sell_id);
        $buyer->sold=1;
        $buyer->track_id=$seller->track_id;
        $seller->quantity=$seller->quantity - $buyer->quantity;

        $buyer->save();
        $seller->save();
        session()->flash('message','Asset order request approved successfuly');
        return redirect()->back();
     }else{
       session()->flash('message','Asset Quantity limit exceeded');
       return redirect()->back();
     }
    }
}
