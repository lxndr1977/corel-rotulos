<?php

use Illuminate\Support\Facades\Route;

Route::get('/product-print-label', function () {
    return view('livewire.product-print-label');
})->name('print');


