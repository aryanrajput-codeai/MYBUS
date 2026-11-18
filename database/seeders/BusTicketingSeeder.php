<?php

namespace Database\Seeders;

use App\Models\BusFleet;
use App\Models\BusOperator;
use App\Models\BusPoint;
use App\Models\BusRoute;
use App\Models\BusSchedule;
use App\Models\BusSeatBooking;
use App\Models\BusSeatLayout;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BusTicketingSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bus Operators
        $operators = [
            [
                'name' => 'NANDAN TOURS Luxury Fleet',
                'code' => 'NANDAN-FLEET',
                'logo' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80',
                'rating' => 4.9,
                'total_reviews' => 1840,
                'contact_phone' => '+91 11 4567 8900',
                'contact_email' => 'support@nandantours.com',
                'address' => 'Plot 45, Barakhamba Road, Connaught Place, New Delhi',
            ],
            [
                'name' => 'Zingbus Electric & Luxury AC',
                'code' => 'ZINGBUS',
                'logo' => 'https://images.unsplash.com/photo-1570125909232-eb263c188f7e?auto=format&fit=crop&w=120&q=80',
                'rating' => 4.8,
                'total_reviews' => 1250,
                'contact_phone' => '+91 80 4680 8888',
                'contact_email' => 'help@zingbus.com',
                'address' => 'Cyber City, Gurugram, Haryana',
            ],
            [
                'name' => 'VRL Travels Platinum Class',
                'code' => 'VRL',
                'logo' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80',
                'rating' => 4.7,
                'total_reviews' => 2450,
                'contact_phone' => '+91 836 2307300',
                'contact_email' => 'customercare@vrllogistics.com',
                'address' => 'Giriraj Annexe, Circuit House Road, Hubballi, Karnataka',
            ],
            [
                'name' => 'IntrCity SmartBus Premium Lounge',
                'code' => 'INTRCITY',
                'logo' => 'https://images.unsplash.com/photo-1570125909232-eb263c188f7e?auto=format&fit=crop&w=120&q=80',
                'rating' => 4.8,
                'total_reviews' => 1630,
                'contact_phone' => '+91 11 4118 7800',
                'contact_email' => 'care@intrcity.com',
                'address' => 'Aerocity, New Delhi',
            ],
            [
                'name' => 'SRS Volvo Multi-Axle Travels',
                'code' => 'SRS',
                'logo' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=120&q=80',
                'rating' => 4.6,
                'total_reviews' => 980,
                'contact_phone' => '+91 80 2680 0000',
                'contact_email' => 'info@srstravels.net',
                'address' => 'Kalidasa Layout, Srinagar, Bangalore, Karnataka',
            ],
        ];

        $operatorModels = [];
        foreach ($operators as $op) {
            $operatorModels[$op['code']] = BusOperator::firstOrCreate(['code' => $op['code']], $op);
        }

        // 2. Bus Routes
        $routes = [
            ['source_city' => 'Delhi', 'destination_city' => 'Manali', 'distance_km' => 540, 'estimated_duration' => '12h 00m', 'is_popular' => true],
            ['source_city' => 'Delhi', 'destination_city' => 'Jaipur', 'distance_km' => 280, 'estimated_duration' => '5h 15m', 'is_popular' => true],
            ['source_city' => 'Bangalore', 'destination_city' => 'Goa', 'distance_km' => 560, 'estimated_duration' => '11h 30m', 'is_popular' => true],
            ['source_city' => 'Mumbai', 'destination_city' => 'Pune', 'distance_km' => 150, 'estimated_duration' => '3h 30m', 'is_popular' => true],
            ['source_city' => 'Bangalore', 'destination_city' => 'Hyderabad', 'distance_km' => 570, 'estimated_duration' => '9h 15m', 'is_popular' => true],
            ['source_city' => 'Delhi', 'destination_city' => 'Shimla', 'distance_km' => 350, 'estimated_duration' => '7h 45m', 'is_popular' => true],
            ['source_city' => 'Chennai', 'destination_city' => 'Bangalore', 'distance_km' => 345, 'estimated_duration' => '6h 00m', 'is_popular' => true],
        ];

        $routeModels = [];
        foreach ($routes as $rt) {
            $key = strtolower($rt['source_city'].'-'.$rt['destination_city']);
            $routeModels[$key] = BusRoute::firstOrCreate(
                ['source_city' => $rt['source_city'], 'destination_city' => $rt['destination_city']],
                $rt
            );
        }

        // 3. Fleets & Seat Layouts
        $fleets = [
            [
                'operator_code' => 'NANDAN-FLEET',
                'bus_number' => 'DL 01 AB 7788',
                'bus_name' => 'NANDAN Royal Diamond 9600 Multi-Axle',
                'bus_type' => 'Volvo 9600 AC Sleeper (2+1)',
                'deck_type' => 'double',
                'total_seats' => 36,
                'amenities' => ['WiFi', 'Charging Point', 'Blanket & Pillow', 'Water Bottle', 'Live GPS Tracking', 'Emergency SOS', 'Reading Lights'],
            ],
            [
                'operator_code' => 'ZINGBUS',
                'bus_number' => 'HR 55 XY 3344',
                'bus_name' => 'Zingbus Electric Premium Sleeper',
                'bus_type' => 'Electric Luxury AC Sleeper (2+1)',
                'deck_type' => 'double',
                'total_seats' => 36,
                'amenities' => ['WiFi', 'Free Snacks & Water', 'Charging Port', 'Sanitized Linen', 'Live Tracking', 'CCTV Security'],
            ],
            [
                'operator_code' => 'INTRCITY',
                'bus_number' => 'DL 01 CD 5566',
                'bus_name' => 'IntrCity SmartBus SmartSuite',
                'bus_type' => 'Scania Multi-Axle AC Sleeper/Seater',
                'deck_type' => 'double',
                'total_seats' => 36,
                'amenities' => ['Boarding Lounge Access', 'Captain on Board', 'WiFi', 'Charging Point', 'Clean Rest Stop Guarantee'],
            ],
            [
                'operator_code' => 'VRL',
                'bus_number' => 'KA 25 Z 9900',
                'bus_name' => 'VRL I-Shift Multi-Axle Luxury',
                'bus_type' => 'Volvo B11R Multi-Axle AC Sleeper',
                'deck_type' => 'double',
                'total_seats' => 36,
                'amenities' => ['Personal LCD Screen', 'Mineral Water', 'Charging Sockets', 'Blanket', 'Punctuality Guarantee'],
            ],
            [
                'operator_code' => 'SRS',
                'bus_number' => 'KA 01 F 1234',
                'bus_name' => 'SRS Executive Club',
                'bus_type' => 'Mercedes Benz Super Luxury (2+2)',
                'deck_type' => 'single',
                'total_seats' => 40,
                'amenities' => ['Deep Reclining Seats', 'AC Climate Control', 'USB Chargers', 'Luggage Tagging'],
            ],
        ];

        $fleetModels = [];
        foreach ($fleets as $fl) {
            $op = $operatorModels[$fl['operator_code']];
            $fleet = BusFleet::firstOrCreate(['bus_number' => $fl['bus_number']], [
                'bus_operator_id' => $op->id,
                'bus_number' => $fl['bus_number'],
                'bus_name' => $fl['bus_name'],
                'bus_type' => $fl['bus_type'],
                'deck_type' => $fl['deck_type'],
                'total_seats' => $fl['total_seats'],
                'amenities' => $fl['amenities'],
                'is_active' => true,
            ]);
            $fleetModels[$fl['bus_number']] = $fleet;

            // Generate standard 2+1 Sleeper Seat Layout (18 lower deck, 18 upper deck)
            if ($fleet->seatLayouts()->count() === 0) {
                // Lower Deck: 6 rows x 3 berths = 18 seats
                // col 1 = single sleeper (L1, L4, L7, L10, L13, L16)
                // col 2 = aisle (walkway)
                // col 3 = window double (L2, L5, L8, L11, L14, L17)
                // col 4 = aisle double (L3, L6, L9, L12, L15, L18)
                $lCount = 1;
                for ($row = 1; $row <= 6; $row++) {
                    BusSeatLayout::create([
                        'bus_fleet_id' => $fleet->id,
                        'deck' => 'lower',
                        'row_num' => $row,
                        'col_num' => 1,
                        'seat_number' => 'L'.$lCount++,
                        'seat_type' => 'sleeper',
                        'is_ladies_quota' => ($row <= 2), // First 2 single berths for ladies
                    ]);
                    BusSeatLayout::create([
                        'bus_fleet_id' => $fleet->id,
                        'deck' => 'lower',
                        'row_num' => $row,
                        'col_num' => 3,
                        'seat_number' => 'L'.$lCount++,
                        'seat_type' => 'sleeper',
                        'is_ladies_quota' => false,
                    ]);
                    BusSeatLayout::create([
                        'bus_fleet_id' => $fleet->id,
                        'deck' => 'lower',
                        'row_num' => $row,
                        'col_num' => 4,
                        'seat_number' => 'L'.$lCount++,
                        'seat_type' => 'sleeper',
                        'is_ladies_quota' => false,
                    ]);
                }

                // Upper Deck: 6 rows x 3 berths = 18 seats
                $uCount = 1;
                for ($row = 1; $row <= 6; $row++) {
                    BusSeatLayout::create([
                        'bus_fleet_id' => $fleet->id,
                        'deck' => 'upper',
                        'row_num' => $row,
                        'col_num' => 1,
                        'seat_number' => 'U'.$uCount++,
                        'seat_type' => 'sleeper',
                        'is_ladies_quota' => ($row == 1),
                    ]);
                    BusSeatLayout::create([
                        'bus_fleet_id' => $fleet->id,
                        'deck' => 'upper',
                        'row_num' => $row,
                        'col_num' => 3,
                        'seat_number' => 'U'.$uCount++,
                        'seat_type' => 'sleeper',
                        'is_ladies_quota' => false,
                    ]);
                    BusSeatLayout::create([
                        'bus_fleet_id' => $fleet->id,
                        'deck' => 'upper',
                        'row_num' => $row,
                        'col_num' => 4,
                        'seat_number' => 'U'.$uCount++,
                        'seat_type' => 'sleeper',
                        'is_ladies_quota' => false,
                    ]);
                }
            }
        }

        // 4. Schedules & Boarding/Dropping Points
        $schedulesData = [
            // Delhi -> Manali
            [
                'fleet' => 'DL 01 AB 7788',
                'route' => 'delhi-manali',
                'departure' => '20:30:00',
                'arrival' => '08:30:00',
                'duration' => '12h 00m',
                'sleeper' => 1499.00,
                'seater' => 999.00,
                'boarding' => [
                    ['point_name' => 'Kashmere Gate Metro Gate 1', 'landmark' => 'Near HP Petrol Pump, Ring Road', 'point_time' => '20:30'],
                    ['point_name' => 'Majnu Ka Tilla', 'landmark' => 'Indian Oil Petrol Pump, Tibetan Market', 'point_time' => '21:00'],
                    ['point_name' => 'Karnal Bypass', 'landmark' => 'Near Mukarba Chowk Flyover', 'point_time' => '21:45'],
                ],
                'dropping' => [
                    ['point_name' => 'Kullu Bypass', 'landmark' => 'Shastri Nagar Bridge', 'point_time' => '07:30'],
                    ['point_name' => 'Manali Private Bus Stand', 'landmark' => 'Mall Road, Manali', 'point_time' => '08:30'],
                ],
            ],
            [
                'fleet' => 'HR 55 XY 3344',
                'route' => 'delhi-manali',
                'departure' => '21:15:00',
                'arrival' => '09:15:00',
                'duration' => '12h 00m',
                'sleeper' => 1349.00,
                'seater' => 899.00,
                'boarding' => [
                    ['point_name' => 'Kashmere Gate ISBT', 'landmark' => 'Counter 32, ISBT Kashmere Gate', 'point_time' => '21:15'],
                    ['point_name' => 'Majnu Ka Tilla', 'landmark' => 'Opposite Monastery Market', 'point_time' => '21:45'],
                    ['point_name' => 'Murthal Pahalwan Dhaba', 'landmark' => 'GT Road, Murthal', 'point_time' => '22:45'],
                ],
                'dropping' => [
                    ['point_name' => 'Manali Private Bus Stand', 'landmark' => 'Govt Bus Stand Annex', 'point_time' => '09:15'],
                ],
            ],
            [
                'fleet' => 'DL 01 CD 5566',
                'route' => 'delhi-manali',
                'departure' => '18:45:00',
                'arrival' => '06:45:00',
                'duration' => '12h 00m',
                'sleeper' => 1599.00,
                'seater' => 1099.00,
                'boarding' => [
                    ['point_name' => 'IntrCity Lounge RK Ashram Metro', 'landmark' => 'Near Metro Pillar 14', 'point_time' => '18:45'],
                    ['point_name' => 'Kashmere Gate Lounge', 'landmark' => 'Inside Mori Gate Terminal', 'point_time' => '19:30'],
                ],
                'dropping' => [
                    ['point_name' => 'Patlikuhal', 'landmark' => 'Highway junction', 'point_time' => '06:00'],
                    ['point_name' => 'Manali Private Bus Stand', 'landmark' => 'Near Mall Road', 'point_time' => '06:45'],
                ],
            ],

            // Delhi -> Jaipur
            [
                'fleet' => 'DL 01 AB 7788',
                'route' => 'delhi-jaipur',
                'departure' => '06:00:00',
                'arrival' => '11:15:00',
                'duration' => '5h 15m',
                'sleeper' => 899.00,
                'seater' => 599.00,
                'boarding' => [
                    ['point_name' => 'Dhaula Kuan Metro', 'landmark' => 'Under Airport Express Flyover', 'point_time' => '06:00'],
                    ['point_name' => 'IFFCO Chowk Gurgaon', 'landmark' => 'Near IFFCO Gate, Expressway', 'point_time' => '06:40'],
                ],
                'dropping' => [
                    ['point_name' => 'Sindhi Camp', 'landmark' => 'Jaipur Central Bus Stand', 'point_time' => '10:45'],
                    ['point_name' => 'Narayan Singh Circle', 'landmark' => 'Near City Palace Road', 'point_time' => '11:15'],
                ],
            ],
            [
                'fleet' => 'HR 55 XY 3344',
                'route' => 'delhi-jaipur',
                'departure' => '15:30:00',
                'arrival' => '21:00:00',
                'duration' => '5h 30m',
                'sleeper' => 799.00,
                'seater' => 499.00,
                'boarding' => [
                    ['point_name' => 'Kashmere Gate', 'landmark' => 'Gate 2 Metro', 'point_time' => '15:30'],
                    ['point_name' => 'Dhaula Kuan', 'landmark' => 'NH 48 Entry', 'point_time' => '16:15'],
                    ['point_name' => 'Rajiv Chowk Gurgaon', 'landmark' => 'Near Medanta cut', 'point_time' => '17:00'],
                ],
                'dropping' => [
                    ['point_name' => 'Transport Nagar', 'landmark' => 'Jaipur Highway Entry', 'point_time' => '20:30'],
                    ['point_name' => 'Sindhi Camp', 'landmark' => 'Platform 4', 'point_time' => '21:00'],
                ],
            ],

            // Bangalore -> Goa
            [
                'fleet' => 'KA 25 Z 9900',
                'route' => 'bangalore-goa',
                'departure' => '19:30:00',
                'arrival' => '07:00:00',
                'duration' => '11h 30m',
                'sleeper' => 1799.00,
                'seater' => 1199.00,
                'boarding' => [
                    ['point_name' => 'Madiwala', 'landmark' => 'Near Total Mall / Shell Petrol Pump', 'point_time' => '19:30'],
                    ['point_name' => 'Majestic Anand Rao Circle', 'landmark' => 'VRL Hub, Seshadripuram', 'point_time' => '20:30'],
                    ['point_name' => 'Yeshwantpur', 'landmark' => 'Govardhan Theatre, Tumkur Road', 'point_time' => '21:15'],
                ],
                'dropping' => [
                    ['point_name' => 'Madgaon Railway Station', 'landmark' => 'KTC Bus Stand Margao', 'point_time' => '06:15'],
                    ['point_name' => 'Panjim KTC Bus Stand', 'landmark' => 'Patto Center, Panjim', 'point_time' => '07:00'],
                ],
            ],

            // Mumbai -> Pune
            [
                'fleet' => 'KA 01 F 1234',
                'route' => 'mumbai-pune',
                'departure' => '07:00:00',
                'arrival' => '10:30:00',
                'duration' => '3h 30m',
                'sleeper' => 550.00,
                'seater' => 450.00,
                'boarding' => [
                    ['point_name' => 'Dadar TT Circle', 'landmark' => 'Near Asiad Bus Stand', 'point_time' => '07:00'],
                    ['point_name' => 'Chembur Amar Mahal', 'landmark' => 'Eastern Express Highway', 'point_time' => '07:30'],
                    ['point_name' => 'Vashi Plaza', 'landmark' => 'Below Vashi Flyover', 'point_time' => '08:00'],
                ],
                'dropping' => [
                    ['point_name' => 'Wakad Hinjewadi Flyover', 'landmark' => 'Mumbai Pune Expressway Exit', 'point_time' => '09:45'],
                    ['point_name' => 'Swargate Bus Stand', 'landmark' => 'Near Laxmi Narayan Theatre', 'point_time' => '10:30'],
                ],
            ],

            // Bangalore -> Hyderabad
            [
                'fleet' => 'KA 25 Z 9900',
                'route' => 'bangalore-hyderabad',
                'departure' => '22:00:00',
                'arrival' => '07:15:00',
                'duration' => '9h 15m',
                'sleeper' => 1450.00,
                'seater' => 950.00,
                'boarding' => [
                    ['point_name' => 'Electronic City Toll', 'landmark' => 'Near Infosys Gate 1', 'point_time' => '22:00'],
                    ['point_name' => 'Silk Board', 'landmark' => 'Near Central Silk Board Junction', 'point_time' => '22:30'],
                    ['point_name' => 'Hebbal Flyover', 'landmark' => 'Airport Expressway cut', 'point_time' => '23:30'],
                ],
                'dropping' => [
                    ['point_name' => 'Shamshabad Airport Junction', 'landmark' => 'ORR Exit Shamshabad', 'point_time' => '06:30'],
                    ['point_name' => 'Ameerpet', 'landmark' => 'Near Metro Station', 'point_time' => '07:15'],
                ],
            ],
        ];

        foreach ($schedulesData as $sd) {
            $fleet = $fleetModels[$sd['fleet']];
            $route = $routeModels[$sd['route']];

            $schedule = BusSchedule::firstOrCreate(
                [
                    'bus_fleet_id' => $fleet->id,
                    'bus_route_id' => $route->id,
                    'departure_time' => $sd['departure'],
                ],
                [
                    'arrival_time' => $sd['arrival'],
                    'duration' => $sd['duration'],
                    'base_fare' => $sd['seater'],
                    'sleeper_fare' => $sd['sleeper'],
                    'seater_fare' => $sd['seater'],
                    'is_active' => true,
                ]
            );

            // Add boarding points
            if ($schedule->points()->count() === 0) {
                $sort = 1;
                foreach ($sd['boarding'] as $bp) {
                    BusPoint::create([
                        'bus_schedule_id' => $schedule->id,
                        'type' => 'boarding',
                        'point_name' => $bp['point_name'],
                        'landmark' => $bp['landmark'],
                        'point_time' => $bp['point_time'],
                        'sort_order' => $sort++,
                    ]);
                }
                foreach ($sd['dropping'] as $dp) {
                    BusPoint::create([
                        'bus_schedule_id' => $schedule->id,
                        'type' => 'dropping',
                        'point_name' => $dp['point_name'],
                        'landmark' => $dp['landmark'],
                        'point_time' => $dp['point_time'],
                        'sort_order' => $sort++,
                    ]);
                }
            }

            // Seed a few demo booked seats for today and tomorrow to demonstrate live occupancy
            if ($schedule->bookings()->count() === 0) {
                $today = Carbon::today();
                BusSeatBooking::create([
                    'bus_schedule_id' => $schedule->id,
                    'pnr_number' => 'PNR-'.strtoupper(bin2hex(random_bytes(4))),
                    'travel_date' => $today->toDateString(),
                    'seat_number' => 'L2',
                    'deck' => 'lower',
                    'seat_type' => 'sleeper',
                    'passenger_name' => 'Vikram Rajput',
                    'passenger_age' => 32,
                    'passenger_gender' => 'male',
                    'contact_phone' => '+91 98111 22334',
                    'contact_email' => 'vikram@example.com',
                    'boarding_point' => $sd['boarding'][0]['point_name'],
                    'dropping_point' => $sd['dropping'][0]['point_name'],
                    'seat_fare' => $sd['sleeper'],
                    'gst_amount' => round($sd['sleeper'] * 0.05, 2),
                    'total_fare' => $sd['sleeper'] + round($sd['sleeper'] * 0.05, 2),
                    'status' => 'confirmed',
                ]);

                BusSeatBooking::create([
                    'bus_schedule_id' => $schedule->id,
                    'pnr_number' => 'PNR-'.strtoupper(bin2hex(random_bytes(4))),
                    'travel_date' => $today->toDateString(),
                    'seat_number' => 'L1', // Ladies seat
                    'deck' => 'lower',
                    'seat_type' => 'sleeper',
                    'passenger_name' => 'Pooja Sharma',
                    'passenger_age' => 28,
                    'passenger_gender' => 'female',
                    'contact_phone' => '+91 98222 33445',
                    'contact_email' => 'pooja@example.com',
                    'boarding_point' => $sd['boarding'][0]['point_name'],
                    'dropping_point' => $sd['dropping'][0]['point_name'],
                    'seat_fare' => $sd['sleeper'],
                    'gst_amount' => round($sd['sleeper'] * 0.05, 2),
                    'total_fare' => $sd['sleeper'] + round($sd['sleeper'] * 0.05, 2),
                    'status' => 'confirmed',
                ]);
            }
        }
    }
}
