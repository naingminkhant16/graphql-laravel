<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can register a new user via the GraphQL API', function () {
    $query = '
        mutation {
            registerUser(input:{
                name:"Test User",
                email:"test@example.com",
                password:"password"
            }){
                id
                name
                email
            }
        }
    ';

    $response = $this->post('/graphql', [
        'query' => $query,
        'variables' => []
    ]);

    $response->assertStatus(200);


    $response->assertJsonStructure([
        'data' => [
            'registerUser' => [
                'id',
                'name',
                'email',
            ],
        ],
    ])->assertJsonFragment([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ])->assertDontSee('errors');

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
        'name' => 'Test User',
    ]);
});

it('returns a GraphQL error for invalid user registration', function () {
    $query = '
        mutation {
            registerUser(input:{
                name:"Invalid User",
                email:"invalid-email",
                password:"password"
            }){
                id
            }
        }
    ';

    $response = $this->post('/graphql', ['query' => $query]);

    $response->assertStatus(200);

    $response->assertJsonStructure([
        'errors' => [
            '*' => [
                'message',
            ],
        ],
    ])->assertJsonPath('data.registerUser', null);
});
