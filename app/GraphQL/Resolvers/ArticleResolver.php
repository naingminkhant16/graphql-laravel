<?php declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use App\Models\Article;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final readonly class ArticleResolver
{
    /**
     * @param $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @param ResolveInfo $resolveInfo
     * @return Article
     */
    public function create($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): Article
    {
        return Article::create([
            'title' => $args['title'],
            'body' => $args['body'],
            'slug' => Str::slug($args['title']),
            'author_id' => Auth::guard('api')->id(),
        ]);
    }
}
