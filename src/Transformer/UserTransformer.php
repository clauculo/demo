<?php

namespace App\Transformer;

use App\Entity\User;

class UserTransformer implements TransformerInterface
{
    /**
     * @param User $user
     */
    public function transform(object $user): array
    {
        return [
            'id' => 34,
            'first_name' => $user->getFirstName(),
            'account' => 'basic',
            'user_image' => 'image'
        ];
    }

}