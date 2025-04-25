<?php

namespace Database\Seeders;

use App\Models\Conversations;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ConversationsSeed extends Seeder
{
    public function run(): void
    {
        Conversations::insert([
            [
                'id' => 1,
                'group' => true,
                'details_group' => (object)[
                    'name' => 'PRIMER GRUPO',
                    'admins' => array_map(fn($a) => (object)$a, [
                        ['id' => 1, 'name' => 'Pablo']
                    ]),
                ],
                'participants' => array_map(fn($p) => (object)$p, [
                    ['id' => 1, 'name' => 'Pablo'],
                    ['id' => 2, 'name' => 'Juan'],
                    ['id' => 3, 'name' => 'Ana'],
                ]),
                'messages' => array_map(fn($m) => (object)[
                    'id' => $m['id'],
                    'message' => $m['message'],
                    'sender' => (object)$m['sender'],
                    'date' => $m['date'],
                ], [
                    [
                        'id' => 1,
                        'message' => 'Primer mensaje',
                        'sender' => ['id' => 1, 'name' => 'Pablo'],
                        'date' => Carbon::parse('2025-04-24 18:32')->format('Y-m-d H:i:s'),
                    ],
                ]),
                'date_created' => Carbon::parse('2025-04-24 18:00')->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'group' => false,
                'participants' => array_map(fn($p) => (object)$p, [
                    ['id' => 1, 'name' => 'Pablo'],
                    ['id' => 2, 'name' => 'Juan'],
                ]),
                'messages' => array_map(fn($m) => (object)[
                    'id' => $m['id'],
                    'message' => $m['message'],
                    'sender' => (object)$m['sender'],
                    'date' => $m['date'],
                ], [
                    [
                        'id' => 1,
                        'message' => 'Hola Juan!',
                        'sender' => ['id' => 1, 'name' => 'Pablo'],
                        'date' => Carbon::parse('2025-04-24 18:32')->format('Y-m-d H:i:s'),
                    ],
                ]),
                'date_created' => Carbon::parse('2025-04-24 18:00')->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
