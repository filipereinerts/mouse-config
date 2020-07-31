@extends('layout')

@section('content')

    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                <span class="d-none d-md-block d-lg-block d-xl-block">
                    Package ratbagd not installed
                    <br/>
                    <span style="font-size: 30px">Execute <kbd style="font-size: 25px"><var>sudo apt-get install ratbagd</var></kbd></span>
                </span>
                <span class="d-md-none d-lg-none d-xl-none" style="font-size: 25px">
                    Package ratbagd not installed
                    <br/>
                    <span style="font-size: 20px">Execute <kbd style="font-size: 15px"><var>sudo apt-get install ratbagd</var></kbd></span>
                </span>
            </div>
        </div>
    </div>

@endsection
