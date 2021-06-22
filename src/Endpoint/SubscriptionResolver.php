<?php


namespace App\Endpoint;

use ApiPlatform\Core\GraphQl\Resolver\QueryCollectionResolverInterface;

/**
 * Class Subscription
 */
final class SubscriptionResolver implements QueryCollectionResolverInterface
{
    public function __invoke(iterable $collection, array $context): iterable
    {
        return $collection;
    }
}