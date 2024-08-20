@extends('layouts.main')
@section('title', 'Servery')

@section('content')
    <servery
    link="{{ config('settings.servery_link') }}"
    ></servery>
@endsection
