<?php

namespace App\Models\Helper;

use App\Models\Tests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestsHelper
{
    public function __construct()
    {
        $tests = Tests::all();

        if (!$tests) {
            $this->fill();
        }
    }

    private function fill(): void
    {
        for ($i = 0; $i < 20; $i++) {
            DB::table('tests')->insert([
                'id' => $i,
                'script_name' => Str::random(10),
                'start_time' => now(),
                'end_time' => now(),
                'result' => Tests::getResultArray()[array_rand(Tests::getResultArray())]
            ]);
        }
    }

    public function get()
    {
        return DB::table('tests')
            ->select('*')
            ->where('result', ['success', 'normal'])
            ->get();
    }

}
