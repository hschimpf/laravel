<?php

use Nwidart\Modules\Facades\Module;

test('that all modules have at least one test', function() {
    expect($modules = Module::all())
        ->not()->toBeEmpty('No modules defined');

    foreach ($modules as $module) {
        expect($module)
            ->toHaveUnitTests();
    }
});
