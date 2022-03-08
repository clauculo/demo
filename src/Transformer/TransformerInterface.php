<?php

namespace App\Transformer;

interface TransformerInterface
{
    public function transform(object $object): array;

}