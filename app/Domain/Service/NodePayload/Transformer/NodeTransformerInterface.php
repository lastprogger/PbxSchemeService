<?php


namespace App\Domain\Service\NodePayload\Transformer;


interface NodeTransformerInterface
{
    public function transform(array $data): array;
}