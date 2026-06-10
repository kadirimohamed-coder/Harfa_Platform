<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Craftsman;
use App\Models\Gig;
use App\Models\GigApplication;
use App\Models\PointTransaction;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Categories ────────────────────────────────────
        $categories = [
            ['name' => 'Plomberie',          'icon' => 'bi-droplet'],
            ['name' => 'Électricité',         'icon' => 'bi-lightning'],
            ['name' => 'Peinture',            'icon' => 'bi-brush'],
            ['name' => 'Maçonnerie',          'icon' => 'bi-bricks'],
            ['name' => 'Menuiserie',          'icon' => 'bi-tools'],
            ['name' => 'Nettoyage',           'icon' => 'bi-stars'],
            ['name' => 'Jardinage',           'icon' => 'bi-tree'],
            ['name' => 'Carrelage',           'icon' => 'bi-grid'],
            ['name' => 'Climatisation',       'icon' => 'bi-thermometer'],
            ['name' => 'Serrurerie',          'icon' => 'bi-key'],
        ];
        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat['name']], $cat);
        }
        $cats = Category::all();

        // ── Admin ─────────────────────────────────────────
        // $admin = User::firstOrCreate(
        //     ['email' => 'admin@harfa.ma'],
        //     [
        //         'name'     => 'Admin Harfa',
        //         'password' => Hash::make('password'),
        //         'role'     => 'admin',
        //         'status'   => 'active',
        //         'city'     => 'Casablanca',
        //     ]
        // );

        // ── Craftsmen ─────────────────────────────────────
        $craftsmenData = [
            ['name' => 'Youssef El Amrani',  'email' => 'youssef@harfa.ma',  'city' => 'Casablanca', 'cat' => 0, 'exp' => 8,  'price' => 250],
            ['name' => 'Khalid Bensouda',    'email' => 'khalid@harfa.ma',   'city' => 'Rabat',      'cat' => 1, 'exp' => 12, 'price' => 300],
            ['name' => 'Mohamed Tahiri',     'email' => 'mohamed@harfa.ma',  'city' => 'Marrakech',  'cat' => 2, 'exp' => 5,  'price' => 200],
            ['name' => 'Hassan Ouazzani',    'email' => 'hassan@harfa.ma',   'city' => 'Fès',        'cat' => 3, 'exp' => 15, 'price' => 350],
            ['name' => 'Rachid Bennani',     'email' => 'rachid@harfa.ma',   'city' => 'Casablanca', 'cat' => 4, 'exp' => 7,  'price' => 280],
            ['name' => 'Omar Chakir',        'email' => 'omar@harfa.ma',     'city' => 'Tanger',     'cat' => 5, 'exp' => 3,  'price' => 150],
            ['name' => 'Nabil Lahrichi',     'email' => 'nabil@harfa.ma',    'city' => 'Agadir',     'cat' => 6, 'exp' => 10, 'price' => 220],
            ['name' => 'Aziz Moutawakil',   'email' => 'aziz@harfa.ma',     'city' => 'Meknès',     'cat' => 7, 'exp' => 6,  'price' => 260],
        ];

        $craftsmenModels = [];
        foreach ($craftsmenData as $cm) {
            $user = User::firstOrCreate(
                ['email' => $cm['email']],
                [
                    'name'     => $cm['name'],
                    'password' => Hash::make('password'),
                    'role'     => 'craftsman',
                    'status'   => 'active',
                    'city'     => $cm['city'],
                    'points'   => rand(10, 100),
                ]
            );

            $craftsman = Craftsman::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'description'         => "Artisan qualifié avec {$cm['exp']} ans d'expérience.",
                    'experience_years'    => $cm['exp'],
                    'price'               => $cm['price'],
                    'availability_status' => true,
                ]
            );

            if ($craftsman->categories()->count() === 0) {
                $craftsman->categories()->attach($cats[$cm['cat']]->id);
            }

            $craftsmenModels[] = ['user' => $user, 'craftsman' => $craftsman];
        }

        // ── Clients ───────────────────────────────────────
        $clientsData = [
            ['name' => 'Fatima Zahra',  'email' => 'fatima@harfa.ma',  'city' => 'Casablanca'],
            ['name' => 'Aicha Benali',  'email' => 'aicha@harfa.ma',   'city' => 'Rabat'],
            ['name' => 'Sara Idrissi',  'email' => 'sara@harfa.ma',    'city' => 'Marrakech'],
        ];

        $clients = [];
        foreach ($clientsData as $cl) {
            $clients[] = User::firstOrCreate(
                ['email' => $cl['email']],
                [
                    'name'     => $cl['name'],
                    'password' => Hash::make('password'),
                    'role'     => 'client',
                    'status'   => 'active',
                    'city'     => $cl['city'],
                ]
            );
        }

        // ── Bookings ──────────────────────────────────────
        if (Booking::count() === 0) {
            $bookingStatuses = ['done', 'confirmed', 'pending', 'cancelled', 'done'];

            foreach ($clients as $idx => $client) {
                foreach (array_slice($craftsmenModels, $idx, 3) as $cmIdx => $cm) {
                    $status = $bookingStatuses[$cmIdx] ?? 'pending';

                    Booking::create([
                        'client_id'    => $client->id,
                        'craftsman_id' => $cm['craftsman']->id,
                        'booking_date' => now()->addDays(rand(1, 30)),
                        'description'  => 'Travaux à effectuer dans l\'appartement.',
                        'address'      => '12 Rue Hassan II, ' . $client->city,
                        'urgency'      => 'normal',
                        'status'       => $status,
                    ]);
                }
            }
        }

        // ── Reviews ───────────────────────────────────────
        if (Review::count() === 0) {
            $doneBookings = Booking::where('status', 'done')->get();
            foreach ($doneBookings as $booking) {
                Review::firstOrCreate(
                    ['booking_id' => $booking->id],
                    [
                        'rating'  => rand(3, 5),
                        'comment' => 'Excellent travail, très professionnel.',
                    ]
                );
            }
        }

        // ── Gigs ──────────────────────────────────────────
        if (Gig::count() === 0) {
            $gigsData = [
                ['title' => 'Réparation fuite robinet cuisine',  'cat' => 0],
                ['title' => 'Peinture salon 30m²',               'cat' => 2],
                ['title' => 'Installation prise électrique',     'cat' => 1],
                ['title' => 'Pose carrelage salle de bain',      'cat' => 7],
                ['title' => 'Nettoyage appartement 90m²',        'cat' => 5],
            ];

            foreach ($gigsData as $i => $gigData) {
                $client = $clients[$i % count($clients)];
                $gig = Gig::create([
                    'user_id'     => $client->id,
                    'category_id' => $cats[$gigData['cat']]->id,
                    'title'       => $gigData['title'],
                    'description' => 'Travail à réaliser dans les meilleurs délais.',
                    'city'        => $client->city,
                    'deadline'    => now()->addWeeks(2),
                    'status'      => 'open',
                ]);

                // Add an application
                $craftsman = $craftsmenModels[$gigData['cat'] % count($craftsmenModels)]['craftsman'];
                $user      = $craftsmenModels[$gigData['cat'] % count($craftsmenModels)]['user'];

                if ($user->points >= 5) {
                    GigApplication::firstOrCreate(
                        ['gig_id' => $gig->id, 'craftsman_id' => $craftsman->id]
                    );
                    $user->decrement('points', 5);
                    PointTransaction::create([
                        'user_id'     => $user->id,
                        'amount'      => -5,
                        'type'        => 'spend',
                        'description' => "Candidature : {$gig->title}",
                    ]);
                }
            }
        }

        // ── Point purchases ───────────────────────────────
        if (PointTransaction::where('type', 'purchase')->count() === 0) {
            foreach (array_slice($craftsmenModels, 0, 3) as $cm) {
                PointTransaction::create([
                    'user_id'     => $cm['user']->id,
                    'amount'      => 50,
                    'type'        => 'purchase',
                    'description' => 'Achat pack starter (50 pts)',
                ]);
                $cm['user']->increment('points', 50);
            }
        }
    }
}
