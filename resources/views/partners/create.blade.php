@extends('layouts.commonMaster')

@section('title', 'Tambah Partner Notaris PPAT')

@section('layoutContent')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 class="mb-0">Tambah Partner</h5>
        </div>
        <div class="card-body">
            {{-- Form partner --}}
            @include('partners.form', ['provinsi' => $provinsi])
        </div>
    </div>
</div>
@endsection
