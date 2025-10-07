<?php declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use App\Models\User;
use Exception;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final readonly class AuthResolver
{
    /**
     * @param $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @param ResolveInfo $resolveInfo
     * @return mixed
     */
    public function register($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): User
    {
        return User::create([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => Hash::make($args['password']),
        ]);
    }

    /**
     * @param $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @param ResolveInfo $resolveInfo
     * @return array
     * @throws Exception
     */
    public function login($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): array
    {
        if (!$token = Auth::guard('api')->attempt(['email' => $args['email'], 'password' => $args['password']]))
            throw new Exception('Invalid credentials');

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => Auth::guard('api')->user(),
        ];
    }

    /**
     * @param $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @param ResolveInfo $resolveInfo
     * @return true
     */
    public function logout($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): bool
    {
        Auth::guard('api')->logout();
        return true;
    }

    public function me($rootValue, array $args): User
    {
        return Auth::guard('api')->user();
    }
}
