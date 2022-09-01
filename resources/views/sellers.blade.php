<!-- Uses layouts.blade.php -->
@extends('layout')

@section('content')
    <form action="{{ url('create/seller') }}" method="post">
        <!-- If @csrf is omitted  a 419 | Page Expired message appears when form is submitted. This is due to a Cross-Site Request Forgery  -->
        @csrf<!-- Equivalent TO: <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
        <div>
            <span class="input-label">NAME/ADDRESS</span>
            <input type="text" name="name_address_input" value="{{ old('name_address_input') }}" class="input-style w700 mb10" placeholder="Add New Seller" autocomplete="off" autofocus="autofocus">
        </div>
        @error('name_address_input')<div><p class="error_fld_inputs">{{ $message }}</p></div>@enderror
        <!--
        To display all errors together: foreach ($errors->all() as $error)
        If nested in HTML, wrap in:
        @if ($errors->any())
        @endif
        -->
        <div class="fl mr20">
            <span class="input-label">COMMISSION(%)</span>
            <input type="text" name="commission_input" value="20" class="input-style w40 mb10" autocomplete="off">
        </div>
        <div class="fl mr20">
            <span class="input-label">CARRIAGE(&pound;)</span>
            <input type="text" name="carriage_input" value="0" class="input-style w40 mb10" autocomplete="off">
        </div>
        <div>
            <input type="submit" name="add_seller" value="Add Seller" class="btn">
        </div>
        <div class="cl"></div>
    </form>
    
    <table class="table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME/ADDRESS</th>
                <th>Commission</th>
                <th>Carriage</th>
            </tr>
        </thead>
        <tbody>
        @foreach($sellers as $seller)
            <tr>
                <td>{{ $seller['id'] }}</td>
                <td>{{ $seller['name_address'] }} <a class="btn float_right" href="{{ url('lots') }}/{{ $date }}/{{ $seller['id'] }}">lots</a></td>
                <td>{{ $seller['commission'] }}%</td>
                <td>{!! $seller['carriage'] !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
