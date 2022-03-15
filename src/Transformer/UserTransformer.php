<?php

namespace App\Transformer;

use App\Entity\User;
use App\Response\ResourceType;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract implements TransformerInterface
{

    public function __construct(
        private ImageTransformer $imageTransformer,
        private ContactTransformer $contactTransformer
    ) {
    }

    protected array $defaultIncludes = [
        'images',
        'contacts',
    ];

    /**
     * @param User $contact
     */
    public function transform(object $contact): array
    {
        return [
            'id' => $contact->getId(),
            'first_name' => $contact->getFirstName(),
            'account' => 'basic',
            'user_image' => 'image',
            'resource_type' => 'users'
        ];
    }

    public function includeImages(User $user)
    {
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();
        $obj3 = new \stdClass();
        $obj1->id = 4;
        $obj2->id = 5;
        $obj3->id = 6;

        return new Collection([$obj1,$obj2,$obj3], $this->imageTransformer);
    }

    public function includeContacts(User $user)
    {

        return new Collection($user->getContacts(), $this->contactTransformer);
    }

}