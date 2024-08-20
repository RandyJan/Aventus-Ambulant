@extends('layouts.main')
@section('title',  $store_slug.' - Products')

@section('content')
    <div class="container mx-auto mt-4 px-6">
        <store-product></store-product>
    </div>
@endsection
