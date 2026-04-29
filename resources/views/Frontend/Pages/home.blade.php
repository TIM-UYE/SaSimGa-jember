@extends('frontend.Layout.app')

@section('title', 'Home')

@section('content')

    @include('frontend.Sections.hero')
    @include('frontend.sections.about')
    @include('frontend.sections.menu')

@endsection