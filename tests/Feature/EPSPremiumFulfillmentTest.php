<?php

namespace Tests\Feature;

use App\Http\Controllers\Frontend\Api\Tutor\EPSPaymentController;
use App\Models\Payment;
use App\Services\EPSPaymentService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Tests\TestCase;

class EPSPremiumFulfillmentTest extends TestCase
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

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->unsignedBigInteger('invoice_check');
            $table->string('transaction_id');
            $table->decimal('amount', 12, 2);
            $table->string('status');
            $table->string('eps_transaction_id')->nullable();
            $table->text('response_data')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tutor_id');
            $table->decimal('amount', 12, 2);
            $table->string('status');
            $table->unsignedBigInteger('package_id')->nullable();
            $table->unsignedBigInteger('membership_id')->nullable();
            $table->string('invoice_type')->nullable();
            $table->string('package_name')->nullable();
            $table->string('tutor_phone')->nullable();
            $table->string('trx_id')->nullable();
            $table->string('merchanttrx_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::create('package_amounts', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('package_name');
            $table->string('duration')->nullable();
            $table->decimal('amount', 12, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('premium_memberships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tutor_id')->nullable();
            $table->string('request_status')->nullable();
            $table->string('payment_status')->nullable();
            $table->timestamps();
        });

        Schema::create('tutors', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_premium_pro')->default(false);
            $table->boolean('is_premium_advance')->default(false);
            $table->timestamp('premium_date')->nullable();
            $table->timestamp('premium_expire')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('tutor_consultation_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->string('payment_status')->nullable();
        });

        Schema::create('consultation_request_checkouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id')->unique();
        });
    }

    public function test_successful_premium_payment_activates_tutor_without_membership_record()
    {
        DB::table('tutors')->insert(['id' => 5688]);
        DB::table('package_amounts')->insert([
            'id' => 1,
            'type' => 'premium',
            'package_name' => 'regular',
            'duration' => 3,
        ]);
        DB::table('invoices')->insert([
            'id' => 19,
            'tutor_id' => 5688,
            'amount' => 10,
            'status' => 'pending',
            'package_id' => 1,
            'invoice_type' => 'premium',
            'package_name' => 'regular',
        ]);
        Payment::create([
            'invoice_id' => 'EPS-ORDER-19',
            'invoice_check' => 19,
            'transaction_id' => '202611281934196705',
            'amount' => 10,
            'status' => 'processing',
        ]);

        $eps = Mockery::mock(EPSPaymentService::class);
        $eps->shouldReceive('verifyTransaction')
            ->once()
            ->with('202611281934196705')
            ->andReturn([
                'MerchantTransactionId' => '202611281934196705',
                'EPSTransactionId' => 'A262034131128E',
                'Status' => 'Success',
                'TotalAmount' => '10.00',
                'FinancialEntity' => 'BKash',
            ]);

        $request = Request::create(
            '/?merchantTransactionId=202611281934196705',
            'GET'
        );
        (new EPSPaymentController($eps))->success($request);

        $this->assertSame('success', DB::table('payments')->where('id', 1)->value('status'));
        $this->assertSame('paid', DB::table('invoices')->where('id', 19)->value('status'));
        $this->assertSame(1, (int) DB::table('tutors')->where('id', 5688)->value('is_premium'));
        $this->assertNotNull(DB::table('tutors')->where('id', 5688)->value('premium_expire'));
    }
}
