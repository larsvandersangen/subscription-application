<?php


namespace App\Endpoint;


use ApiPlatform\Core\GraphQl\Resolver\MutationResolverInterface;
use App\Entity\Subscription;

class SubscriptionMutator implements MutationResolverInterface
{

    /**
     * @param Subscription|null $item
     * @param array $context
     * @return object|null
     */
    public function __invoke($item, array $context)
    {
        $email = $context['args']['input']['changeEmailTo'];

        $item->getEmail()->setEmail($email);

        return $item;
    }
}