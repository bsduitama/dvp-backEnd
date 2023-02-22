<?php

namespace Tests\Feature;

use App\Models\Tiket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TiketTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    function test_query_tikets_with_paginator()
    {
        // Preparacion
        $tikets= Tiket::factory()->count(5)->create();

        // Ejecucion
        $response = $this->graphQL('query Tikets{
            tikets(page: 0, first: 5) {
              paginatorInfo {
                total
                firstItem
                lastItem
              }
              data {
                id
                status
                user
                created_at
                updated_at
              }
            }
        }');

        // Evaluacion
        $response->assertJsonStructure([
            'data' => [
                'tikets' => [
                    'paginatorInfo' => [
                        // 'total',
                        'firstItem',
                        'lastItem',
                    ],
                    'data' => [
                        '*' =>[
                            'id',
                            'status',
                            'user',
                            'created_at',
                            'updated_at',
                        ]
                    ]
                ],
            ]
        ]);
    }

    public function test_query_tiket_id()
    {
        // Preparacion
        $tiket= Tiket::factory()->create();

        // Ejecucion
        $response = $this->graphQL('query TiketId {
            tiket(id: '. $tiket->id .'){
                id
                status
                user
                created_at
                updated_at
            }
          }');

        // Evaluacion
        $response->assertJSon([
            'data' => [
                'tiket' => [
                    'id' => $tiket->id,
                    'status' => $tiket->status,
                    'user' => $tiket->user,
                    'created_at' => $tiket->created_at,
                    'updated_at' => $tiket->updated_at,
                ],
            ]
        ]);
    }

    public function test_mutation_create_tiket()
    {
        // Preparacion
        // Ejecucion
        $response = $this->graphQL('mutation CreateTiket{
            createTiket(input: {
              user: "Brayan.Duitama"
              status: CLOSE
            }){
              id
              status
              user
              created_at
              updated_at
            }
          }');

        // Evaluacion
        $response->assertJSon([
            'data' => [
                'createTiket' => [
                    'status' => 'close',
                    'user' => 'Brayan.Duitama',
                ],
            ]
        ]);
        $this->assertDatabaseHas('tikets', [
            'status' => 'close',
            'user' => 'Brayan',
        ]);
    }

    public function test_mutation_update_tiket()
    {
        // Preparacion
        $tiket = Tiket::factory()->state([
            'status' => 'open'
        ])->create();
        // Ejecucion
        $response = $this->graphQL('mutation UpdateTiket{
            updateTiket(input: {
              id: '. $tiket->id .'
              status: CLOSE
              user: "bsduitama"
            })
            {
              id
              status
              user
              created_at
              updated_at
            }
          }');

        // Evaluacion
        $response->assertJSon([
            'data' => [
                'updateTiket' => [
                    'id' => $tiket->id ,
                    'status' => 'close',
                    'user' => 'bsduitama',
                ],
            ]
        ]);
        $this->assertDatabaseHas('tikets', [
            'id' => $tiket->id ,
            'status' => 'close',
            'user' => 'bsduitama',
        ]);

    }

    public function test_mutation_delete_tiket()
    {
        // Preparacion
        $tiket = Tiket::factory()->state([
            'status' => 'open'
        ])->create();
        // Ejecucion
        $response = $this->graphQL('mutation DeleteTiket{
            deleteTiket(input: {
              id: '. $tiket->id .'
            })
        }');

        // Evaluacion
        $response->assertJSon([
            'data' => [
                'deleteTiket' => 'El tiket con ID: '.$tiket->id.' fue eliminado'
            ]
        ]);
        $this->assertDatabaseMissing('tikets', [
            'id' => $tiket->id ,
        ]);

    }
}
