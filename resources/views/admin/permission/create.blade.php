@extends('layouts.app')
@section('title', __('Create permission'))
@section('content')
<div class="card bg-white">
    <div class="p-6 rounded-t rounded-r mb-0 border-b border-blueGray-200">
        <div class="card-header-container flex flex-wrap">
            <h6 class="text-xl font-bold text-gray-700">
                {{ __('Create permission') }}
            </h6>
        </div>
    </div>
    <div class="p-4">
        @livewire('permission.create')
    </div>
</div>
@endsection