<?php
namespace App\Factories;


class DriverFactory {
    public function create($oAuthType) {
        return (new ('App\Factories\Drivers\\'.ucfirst("$oAuthType").'Driver')())
            ->connect($oAuthType);
    }
}
