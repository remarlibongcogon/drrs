@extends('layouts.layout')

@section('content')
    <div class="d-flex flex-column m-md-2">
        <x-family-assistance-table label="Family Assistance Records" :datas="$datas"/>

    </div>
@endsection

@section('js')
@endsection