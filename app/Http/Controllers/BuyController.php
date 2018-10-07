<?php

namespace tita\Http\Controllers;

use Illuminate\Http\Request;
use tita\Sell;
use tita\Buy;

class BuyController extends Controller
{
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
       $search_status=0;
        $buys=Sell::where('sold','=',0)->where('quantity' ,'>',0)->simplePaginate(3);
        return view('buy', compact('buys','search_status'));
    }

    public function search(){
      $search_status=1;
      $buys = Sell::whereBetween('quantity',[0, request('quantity')])->where('sold','=',0)->where('quantity' ,'>',0)->orWhere('asset','=',request('asset'))->simplePaginate(4);
      return view('buy', compact('buys','search_status'));
    }

    public function process(Request $request){
      $this->validate($request, [
        'quantity' => 'required',
        'bid'=>'required',
        'buyid'=>'required'
      ]);
      // dd(Sell::where('id','=',request('buyid'))->get(['seller_id'])->value());

      if(auth()->user()->tita >= $request->quantity * $request->bid && Sell::find(request('buyid'))->seller_id != auth()->id()){
        $asset=Sell::findORFail(request('buyid'));
        Buy::create([
         'sell_id'=> request('buyid'),
         'track_id'=> '',
         'seller_id'=> Sell::find(request('buyid'))->seller_id,
         'buyer_id'=> auth()->id(),
         'quantity'=> request('quantity'),
         'bid'=> $asset->bid,
         'asset'=> $asset->asset,
         'verified'=>0
       ]);
       session()->flash('message','Asset order request submitted successfuly');
       return redirect()->back();
     }elseif ( Sell::find(request('buyid'))->seller_id == auth()->id()) {
       session()->flash('message','You cannot buy your Asset');
       return redirect()->back();
     }else{
       session()->flash('message','You do not have enough TITA to make this transaction');
       return redirect()->back();
     }
    }
}
