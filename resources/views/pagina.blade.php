@extends('layout.es')
@php
    $pageTitle = $pagina->meta_title ?: $pagina->titulo;
    $pageDesc = $pagina->meta_description ?: ($pagina->extracto ?: '');
    $pageKeys = $pagina->meta_keywords ?: '';
@endphp
@section('titulo', $pageTitle)
@section('palabras', $pageKeys)
@section('descripcion', $pageDesc)
@section('contenido')
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ $pagina->titulo }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>{{ $pagina->titulo }}</li>
                </ul>
            </div>
        </div>
    </div>
    <section class="space">
        <div class="container">
            @if ($pagina->imagen)
                <div class="mb-4">
                    <img src="{{ Storage::url($pagina->imagen) }}" alt="{{ $pagina->titulo }}" class="w-100 rounded" loading="lazy">
                </div>
            @endif
            @if ($pagina->extracto)
                <p class="lead">{{ $pagina->extracto }}</p>
            @endif
            <div class="page-content">
                {!! $pagina->contenido !!}
            </div>
        </div>
    </section>
@endsection
