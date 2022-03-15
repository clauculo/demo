<?php

namespace App\Transformer;

use App\Entity\User;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class ContactTransformer extends TransformerAbstract implements TransformerInterface
{

    /**
     * @param Contact $contact
     */
    public function transform(object $contact): array
    {
        return [
            'id' => $contact->getId(),
            'first_name' => $contact->getFirstName(),
            'resource_type' => 'contacts'
        ];
    }
}