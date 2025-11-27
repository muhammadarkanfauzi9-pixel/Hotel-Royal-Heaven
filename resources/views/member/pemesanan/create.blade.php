@extends('layouts.app')

@section('page_title', 'Form Pemesanan Kamar')
@include('components.hero-section')
@section('content')
    <div class="max-w-3xl mx-auto">
        <livewire:booking-form :selectedKamarId="$selectedKamarId" />
    </div>
@endsection
