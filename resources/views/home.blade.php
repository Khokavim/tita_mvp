@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><img src="/images/tita-coin.png" width="60px" height="60px" alt=""> {{ auth()->user()->tita }} TITA</div>

                <div class="card-body">
                  <div class="row">

                  <div class="col-md-2">
                   <span class="fa fa-dashboard"></span> Total Transactions
                  </div>
                  <div class="col-md-2">
                  <span class="fa fa-shopping-cart"></span> Buy Orders
                  </div>
                  <div class="col-md-2">
                  <span class="fa fa-shopping-cart"></span> Sell Orders
                  </div>
                  <div class="col-md-2">
                  <span class="fa fa-shopping-bag"></span> Confirmed Deliveries
                  </div>
                  <div class="col-md-2">
                   <span class="fa fa-star">Ratings</span>
                  </div>
                  <div class="col-md-2">
                    <span class="fa fa-recycle"> Transact</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    {{ tita\Sell::where('seller_id','=',auth()->id())->count() + tita\Buy::where('buyer_id','=',auth()->id())->count() }}
                  </div>
                  <div class="col-md-2">
                    {{ tita\Buy::where('buyer_id','=',auth()->id())->count()}}

                  </div>
                  <div class="col-md-2">
                    {{ tita\Sell::where('seller_id','=',auth()->id())->count() }}
                  </div>
                  <div class="col-md-2">
                    {{tita\Buy::where('buyer_id','=',auth()->id())->where('verified','=',1)->count()}}
                  </div>
                  <div class="col-md-2">
                    {{ auth()->user()->ratings }}
                  </div>
                <div class="col-md-2" style="color:white;">
                  <span class="btn btn-success"><a style="color:white;" href="/buy">Buy</a> </span>
                  <span class="btn btn-danger"><a style="color:white;" href="/sell">Sell</a> </span>

                  <!-- <a href="#" class="btn">Sell</a> -->
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
