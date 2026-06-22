@extends('layouts.app')
<link href="{{ asset('backend/css/dashboard_setting_sidenav.css') }}" rel="stylesheet" />

{{-- @push('css')
<link href="{{ asset('backend/css/dashboard_setting_sidenav.css') }}" rel="stylesheet" />
@endpush --}}

@section('content')


<x-backend.layouts.partials.setting_sidenav/>


{{ $slot }}

@endsection





