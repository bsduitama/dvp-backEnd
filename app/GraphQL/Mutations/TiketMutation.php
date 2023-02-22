<?php

namespace App\GraphQL\Mutations;
use Illuminate\Support\Arr;
use App\Models\Tiket;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Type\Definition\ResolveInfo;
use App\Exceptions\GraphQLException;

final class TiketMutation
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function create($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $tiket = new Tiket();

        $tiket->user = $args['user'];

        if (Arr::exists($args, 'status')) {
            $tiket->status = $args['status'];
        }

        $tiket->save();

        return $tiket->refresh();
    }

    public function update($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $tiket = Tiket::find($args['id']);

        if (!$tiket) {
            throw new GraphQLException(
                'El ID: '.$args['id'].' no pertenece a ningun registro en la base de datos', ''
            );
        }

        if (Arr::exists($args, 'user')) {
            $tiket->user = $args['user'];
        }

        if (Arr::exists($args, 'status')) {
            $tiket->status = $args['status'];
        }

        $tiket->save();

        return $tiket->refresh();
    }

    public function delete($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $tiket = Tiket::find($args['id']);

        if (!$tiket) {
            throw new GraphQLException(
                'El ID: '.$args['id'].' no pertenece a ningun registro en la base de datos', ''
            );
        }

        $tiket->delete();

        return 'El tiket con ID: ' . $args['id'] . ' fue eliminado';
    }





}
