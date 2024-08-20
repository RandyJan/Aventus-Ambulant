@extends('layouts.main')
@section('title', 'Pending Orders')

@section('content')
    <div class="container mx-auto mt-4 px-6">

        @if (in_array(config('settings.app_type'), ['invoicer_ambulant']))
            <collections.index></collections.index>
        @endif

        @if (in_array(config('settings.app_type'), ['shell_ambulant', 'restaurant_ambulant']))
            <pending-orderslip></pending-orderslip>
        @endif

    </div>
@endsection
