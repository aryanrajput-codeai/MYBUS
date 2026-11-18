<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Bus Operators
        Schema::create('bus_operators', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('code', 50)->unique();
            $table->string('logo')->nullable();
            $table->decimal('rating', 2, 1)->default(4.5);
            $table->unsignedInteger('total_reviews')->default(120);
            $table->string('contact_phone', 25)->nullable();
            $table->string('contact_email', 150)->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Bus Routes
        Schema::create('bus_routes', function (Blueprint $table) {
            $table->id();
            $table->string('source_city', 100)->index();
            $table->string('destination_city', 100)->index();
            $table->unsignedInteger('distance_km')->default(350);
            $table->string('estimated_duration', 50)->default('7h 30m');
            $table->boolean('is_popular')->default(false);
            $table->timestamps();
        });

        // 3. Bus Fleets
        Schema::create('bus_fleets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_operator_id')->constrained('bus_operators')->cascadeOnDelete();
            $table->string('bus_number', 50);
            $table->string('bus_name', 150);
            $table->string('bus_type', 100); // e.g. 'Volvo 9600 AC Sleeper (2+1)', 'Scania Multi-Axle AC (2+2)'
            $table->enum('deck_type', ['single', 'double'])->default('double');
            $table->unsignedInteger('total_seats')->default(36);
            $table->json('amenities')->nullable(); // ['WiFi', 'Charging Point', 'Water Bottle', 'Blanket', 'Reading Light', 'Live Tracking']
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 4. Bus Schedules
        Schema::create('bus_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_fleet_id')->constrained('bus_fleets')->cascadeOnDelete();
            $table->foreignId('bus_route_id')->constrained('bus_routes')->cascadeOnDelete();
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->string('duration', 50);
            $table->decimal('base_fare', 10, 2)->default(799.00);
            $table->decimal('sleeper_fare', 10, 2)->default(1299.00);
            $table->decimal('seater_fare', 10, 2)->default(799.00);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 5. Boarding & Dropping Points
        Schema::create('bus_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_schedule_id')->constrained('bus_schedules')->cascadeOnDelete();
            $table->enum('type', ['boarding', 'dropping'])->index();
            $table->string('point_name', 150);
            $table->string('landmark', 255)->nullable();
            $table->string('point_time', 20); // e.g. "21:30"
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // 6. Bus Seat Layout
        Schema::create('bus_seat_layouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_fleet_id')->constrained('bus_fleets')->cascadeOnDelete();
            $table->enum('deck', ['lower', 'upper'])->default('lower');
            $table->unsignedSmallInteger('row_num');
            $table->unsignedSmallInteger('col_num');
            $table->string('seat_number', 10); // e.g. "L1", "L2", "U1", "U2"
            $table->enum('seat_type', ['sleeper', 'seater'])->default('sleeper');
            $table->boolean('is_ladies_quota')->default(false);
            $table->timestamps();
        });

        // 7. Bus Seat Bookings (Live Reservations)
        Schema::create('bus_seat_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_schedule_id')->constrained('bus_schedules')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->string('pnr_number', 50)->unique()->index();
            $table->date('travel_date')->index();
            $table->string('seat_number', 10);
            $table->string('deck', 10)->default('lower');
            $table->string('seat_type', 20)->default('sleeper');
            $table->string('passenger_name', 150);
            $table->unsignedSmallInteger('passenger_age');
            $table->enum('passenger_gender', ['male', 'female', 'other']);
            $table->string('contact_phone', 25);
            $table->string('contact_email', 150);
            $table->string('boarding_point', 150)->nullable();
            $table->string('dropping_point', 150)->nullable();
            $table->decimal('seat_fare', 10, 2);
            $table->decimal('gst_amount', 10, 2)->default(0.00);
            $table->decimal('total_fare', 10, 2);
            $table->enum('status', ['confirmed', 'cancelled', 'locked'])->default('confirmed');
            $table->string('payment_status', 30)->default('paid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_seat_bookings');
        Schema::dropIfExists('bus_seat_layouts');
        Schema::dropIfExists('bus_points');
        Schema::dropIfExists('bus_schedules');
        Schema::dropIfExists('bus_fleets');
        Schema::dropIfExists('bus_routes');
        Schema::dropIfExists('bus_operators');
    }
};
