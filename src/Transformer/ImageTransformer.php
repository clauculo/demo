<?php

namespace App\Transformer;

use App\Entity\User;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class ImageTransformer extends TransformerAbstract
{

    /**
     * @param object $image
     */
    public function transform(object $image): array
    {
        return [
            'id' => $image->id,
            'resource_type' => 'images'
        ];
    }
}