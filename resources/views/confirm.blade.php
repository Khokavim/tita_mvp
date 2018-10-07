@extends('layouts.app')

@section('content')
<div class="container">
  @if($flash=session('message'))
  <div class="alert alert-success" style="background-color:;color:black;">
    {{ $flash }}
  </div>
  @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><span style="font-size:25px;"><b>Confirm Asset Delivery   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span> <img src="/images/tita-coin.png" width="60px" height="60px" alt=""> {{ auth()->user()->tita }} TITA</div>
                <div class="card-body">
                  <form method="POST" action="/confirm">
                      @csrf
                      <div class="form-group row">
                          <label for="email" class="col-md-4 col-form-label text-md-right">Track ID</label>

                          <div class="col-md-6">
                              <input id="number" type="text" class="form-control{{ $errors->has('track_id') ? ' is-invalid' : '' }}" name="track_id" value="{{ old('track_id') }}" required>

                              @if ($errors->has('track_id'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('track_id') }}</strong>
                                  </span>
                              @endif
                          </div>
                      </div>

                      <div class="form-group row mb-0">
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn" style="background-color:#08157B;color:white;">
                                  {{ __('Submit Track ID') }}
                              </button>
                          </div>
                      </div>
                  </form><br><br>
                  <h3> Confirmed Deliveries </h3>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#TXID</th>
                        <th>Asset</th>
                        <th>Quantity</th>
                        <th>Bid</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($confirms as $confirm)
                      <tr>
                        <td>{{ $confirm->track_id}}</td>
                        <td>{{ $confirm->asset }}</td>
                        <td>{{ $confirm->quantity }} KG</td>
                        <td>{{ $confirm->bid }} TITA/KG</td>
                        <td>{{ $confirm->created_at->toFormattedDateString() }}</td>
                      </tr>
                      @endforeach
                      {{ $confirms->links() }}
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
