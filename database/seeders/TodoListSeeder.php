<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TodoList;
use Carbon\Carbon;

class TodoListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Membuat data todo list untuk rumah/kantor terapi pasien anak
        $todoListData = [
            [
                'task' => 'Therapist team meeting',
                'deadline' => Carbon::now()->addDays(1)->toDateString(),
            ],
            [
                'task' => 'Therapy session with patient A',
                'deadline' => Carbon::now()->addDays(2)->toDateString(),
            ],
            [
                'task' => 'Activity report preparation',
                'deadline' => Carbon::now()->addDays(3)->toDateString(),
            ],
            [
                'task' => 'Therapy session with patient B',
                'deadline' => Carbon::now()->addDays(4)->toDateString(),
            ],
            [
                'task' => 'Procurement of therapy equipment',
                'deadline' => Carbon::now()->addDays(5)->toDateString(),
            ],
            [
                'task' => 'Therapy session with patient C',
                'deadline' => Carbon::now()->addDays(6)->toDateString(),
            ],
            [
                'task' => 'Coordination with medical team',
                'deadline' => Carbon::now()->addDays(7)->toDateString(),
            ],
        ];
        

        // Memasukkan data ke database
        TodoList::insert($todoListData);
    }
}
