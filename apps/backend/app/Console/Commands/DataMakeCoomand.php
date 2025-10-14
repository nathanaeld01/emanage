<?php

namespace App\Console\Commands;

use InterNACHI\Modular\Console\Commands\Make\Modularize;
use Spatie\LaravelData\Commands\DataMakeCommand as BaseCommand;

class DataMakeCoomand extends BaseCommand {
    use Modularize {
        getDefaultNamespace as getDefaultNamespaceTrait;
        qualifyClass as qualifyClassTrait;
    }

    protected function getDefaultNamespace($rootNamespace): string {
        return $this->getDefaultNamespaceTrait($rootNamespace);
    }

    protected function qualifyClass($name): string {
        return $this->qualifyClassTrait($name);
    }
}
