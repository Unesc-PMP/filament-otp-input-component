<?php

use Filament\Schemas\Schema;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use HasanAhani\FilamentOtpInput\Tests\Fixtures\Livewire;
use HasanAhani\FilamentOtpInput\Components\OtpInput;

use Illuminate\Support\Str;
use function Pest\Livewire\livewire;

it('can be rendered', function () {
    $field = (new OtpInput($name = Str::random()))
        ->numberInput($number = 5)
        ->container(Schema::make(Livewire::make()));

    expect($field)
        ->getStatePath()->toBe($name);

    expect($field)->getNumberInput()->toBe($number);
});

