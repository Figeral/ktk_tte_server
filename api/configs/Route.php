<?php
#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_METHOD)]
class Route
{
    public function __construct(public string $method, public  string $path) {}
}
