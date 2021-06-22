<?php


namespace App\Endpoint;

use ApiPlatform\Core\GraphQl\Resolver\QueryItemResolverInterface;

final class SubscriptionItemResolver implements QueryItemResolverInterface
{
    public function __invoke($item, array $context)
    {
        return $item;
    }
}