@forelse (getCurrencies() as $currency)
<option value="{{$currency->id}}" >{{$currency->code}}</option>
@empty
    
@endforelse
{{-- <option value="UGX">UGX</option>
<option value="USD">USD</option>
<option value="GBP">GBP</option>
<option value="EUR">EUR</option> --}}
