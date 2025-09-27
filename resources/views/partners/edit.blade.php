@extends('layouts.commonMaster')

@section('title', 'Edit Partner Notaris PPAT')

@section('layoutContent')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 class="mb-0">Edit Partner</h5>
        </div>
        <div class="card-body">
            @include('partners.form', [
                'provinsi' => $provinsi,
                'kabupaten' => $kabupaten,
                'partner' => $partner
            ])
        </div>
    </div>
</div>
@endsection
