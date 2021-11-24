@extends('layouts.app')

@section('content')
{{-- App: Vueのルートコンポーネント --}}
<App :user="{{ auth()->user() }}">
    
</App>
@endsection
