<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/characters', function() {
    $response = Http::get('https://rickandmortyapi.com/api/character');
    return $response->json();
});
