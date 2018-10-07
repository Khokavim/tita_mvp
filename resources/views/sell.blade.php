@extends('layouts.app')

@section('content')
<div class="container">
  @if($flash=session('message'))
  <div class="alert alert-success" style="color:black;">
    {{ $flash }}
  </div>
  @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><span style="font-size:25px;"><b>Sell ASSET   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span> <img src="/images/tita-coin.png" width="60px" height="60px" alt=""> {{ auth()->user()->tita }} TITA</div>
                <div class="card-body">
                  <form method="POST" action="/sell">
                      @csrf

                      <div class="form-group row">
                          <label for="name" class="col-md-4 col-form-label text-md-right">Asset</label>
                          <select class="" name="asset" required>
                            <option value="Cocoa">Cocoa</option>
                            <option value="Gold">Gold</option>
                            <option value="Leather">Leather</option>
                            <option value="Cobalt">Cobalt</option>
                            <option value="Vibranium">Vibranium</option>
                          </select>
                      </div>

                      <div class="form-group row">
                          <label for="email" class="col-md-4 col-form-label text-md-right">Quantity</label>

                          <div class="col-md-6">
                              <input id="number" type="number" class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" name="quantity" value="{{ old('quantity') }}" placeholder="KG" required>

                              @if ($errors->has('quantity'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('quantity') }}</strong>
                                  </span>
                              @endif
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="email" class="col-md-4 col-form-label text-md-right">Bid - TITA/Asset (KG)</label>

                          <div class="col-md-6">
                              <input id="number" type="number" class="form-control{{ $errors->has('bid') ? ' is-invalid' : '' }}" name="bid" value="{{ old('bid') }}" placeholder="e.g 2.6 TITA/KG" required>

                              @if ($errors->has('bid'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('bid') }}</strong>
                                  </span>
                              @endif
                          </div>
                      </div>

                      <div class="form-group row mb-0">
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-default" style="background-color:#08157B;color:white;">
                                  {{ __('Submit Order') }}
                              </button>
                          </div>
                      </div>
                  </form><br><br>
                  <h3>Buyers</h3>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#TXID</th>
                        <th>Asset</th>
                        <th>Quantity</th>
                        <th>Bid</th>
                        <th>Buyer</th>
                        <th>Country</th>
                        <th>Date</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($bids as $bid)
                      <tr>
                        <td>{{ $bid->track_id }}</td>
                        <td>{{ $bid->asset }}</td>
                        <td>{{ $bid->quantity }} kG</td>
                        <td>{{ $bid->bid }} TITA/KG</td>
                        <td>{{ tita\User::find($bid->buyer_id)->name}}</td>
                        <td>{{ tita\User::find($bid->buyer_id )->country}}</td>
                        <td>{{ $bid->updated_at->toFormattedDateString() }}</td>
                        <td>
                          @if($bid->sold == 0 && $bid->verified == 0)
                         <span class="btn btn-warning"><a style="color:black;" href="/sell/{{ $bid->id }}">Aprrove</a> </span>
                          @elseif($bid->sold == 1 && $bid->verified == 0)
                          <span class="btn btn-warning">Shipment Transit</span>
                          @elseif($bid->verified == 1)
                          <span class="btn btn-success">Delivered</span>
                          @endif
                         </td>
                      </tr>
                      @endforeach
                      {{ $bids->links() }}
                    </tbody>
                  </table>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection
