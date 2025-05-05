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
                    'name' => 'First group',
                    'admins' => array_map(fn($a) => (object)$a, [
                        ['id' => 1, 'name' => 'Sebastian García']
                    ]),
                ],
                'participants' => array_map(fn($p) => (object)$p, [
                    ['id' => 1, 'name' => 'Sebastian García'],
                    ['id' => 2, 'name' => 'Fernando Gómez'],
                    ['id' => 3, 'name' => 'Juana Gutierrez'],
                ]),
                'messages' => array_map(fn($m) => (object)[
                    'id' => $m['id'],
                    'message' => $m['message'],
                    'sender' => (object)$m['sender'],
                    'date' => $m['date'],
                ], [
                    [
                        'id' => 1,
                        'message' => 'Hello friends!',
                        'sender' => ['id' => 1, 'name' => 'Sebastian García'],
                        'date' => Carbon::parse('2025-04-24 18:32')->format('Y-m-d H:i:s'),
                    ],
                    [
                        'id' => 2,
                        'message' => 'Hello Sebastian!',
                        'sender' => ['id' => 3, 'name' => 'Juana Gutierrez'],
                        'date' => Carbon::parse('2025-04-24 18:40')->format('Y-m-d H:i:s'),
                    ],
                ]),
                'date_created' => Carbon::parse('2025-04-24 18:00')->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'group' => false,
                'participants' => array_map(fn($p) => (object)$p, [
                    ['id' => 1, 'name' => 'Sebastian García'],
                    ['id' => 2, 'name' => 'Fernando Gómez'],
                ]),
                'messages' => array_map(fn($m) => (object)[
                    'id' => $m['id'],
                    'message' => $m['message'],
                    'sender' => (object)$m['sender'],
                    'date' => $m['date'],
                ], [
                    [
                        'id' => 1,
                        'message' => 'Hello Sebastian!',
                        'sender' => ['id' => 2, 'name' => 'Fernando Gómez'],
                        'date' => Carbon::parse('2025-04-24 19:30')->format('Y-m-d H:i:s'),
                    ],
                ]),
                'date_created' => Carbon::parse('2025-04-24 18:00')->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
