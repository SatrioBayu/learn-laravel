<?php

namespace App\Services;


class HelloServiceIndonesia implements HelloService
{
    function hello(string $name): string
    {
        return "Halo $name";
    }
}
