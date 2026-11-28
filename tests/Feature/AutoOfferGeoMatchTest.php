<?php

namespace Tests\Feature;

use App\Http\Controllers\Backend\JobOffer\AddOfferController;
use App\Models\JobOffer;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use ReflectionMethod;
use Tests\TestCase;

class AutoOfferGeoMatchTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'database.connections.sqlite.prefix' => '',
        ]);
        DB::purge('sqlite');

        Schema::create('tutors', function (Blueprint $table) {
            $table->id();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
        });

        $pdo = DB::connection()->getPdo();
        $pdo->sqliteCreateFunction('RADIANS', 'deg2rad', 1);
        $pdo->sqliteCreateFunction('SIN', 'sin', 1);
        $pdo->sqliteCreateFunction('COS', 'cos', 1);
        $pdo->sqliteCreateFunction('ASIN', 'asin', 1);
        $pdo->sqliteCreateFunction('SQRT', 'sqrt', 1);
        $pdo->sqliteCreateFunction('POWER', 'pow', 2);
    }

    public function test_auto_match_includes_tutors_within_ten_kilometers_only()
    {
        DB::table('tutors')->insert([
            ['id' => 1, 'lat' => '23.8103', 'long' => '90.4125'],
            ['id' => 2, 'lat' => '23.8553', 'long' => '90.4125'],
            ['id' => 3, 'lat' => '23.9103', 'long' => '90.4125'],
            ['id' => 4, 'lat' => null, 'long' => null],
        ]);

        $query = DB::table('tutors');
        $jobOffer = new JobOffer([
            'lat' => '23.8103',
            'long' => '90.4125',
        ]);
        $method = new ReflectionMethod(AddOfferController::class, 'applyAutoMatchRadius');
        $method->setAccessible(true);
        $method->invoke(new AddOfferController(), $query, $jobOffer, 10);

        $matchedTutorIds = $query->orderBy('id')->pluck('id')->map(function ($id) {
            return (int) $id;
        })->all();

        $this->assertSame([1, 2], $matchedTutorIds);
    }
}
