<?php

/*
 * This file is part of the OverblogGraphQLBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\GraphQLBundle\Relay\Node;

use GraphQL\Executor\Promise\PromiseAdapter;

class PluralIdentifyingRootFieldResolver
{
    /**
     * @var PromiseAdapter
     */
    private $promiseAdapter;

    public function __construct(PromiseAdapter $promiseAdapter)
    {
        $this->promiseAdapter = $promiseAdapter;
    }

    public function resolve(array $inputs, $context, $info, callable $resolveSingleInput)
    {
        $data = [];

        foreach ($inputs as $input) {
            $data[$input] = $this->promiseAdapter->createFulfilled(call_user_func_array($resolveSingleInput, [$input, $context, $info]));
        }

        return $this->promiseAdapter->all($data);
    }
}
