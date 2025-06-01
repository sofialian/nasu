<?php

namespace Database\Seeders;

use App\Models\Furniture;
use App\Models\Room;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            // 1. First, ensure default furniture exists
            $this->createDefaultFurnitureIfMissing();

            // 2. Create test user
            $user = User::create([
                'name' => 'test',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            // 3. Create user balance
            UserBalance::create([
                'user_id' => $user->id,
                'beans' => 100
            ]);

            // 4. Get default furniture (now guaranteed to exist)
            $defaultFurniture = Furniture::where('is_default', true)->get();

            // 5. Create the room - with DEBUGGING
            $room = Room::create([
                'user_id' => $user->id,
                'layout' => [
                    'items' => $defaultFurniture->map(function ($item, $index) {
                        return [
                            'id' => $item->id,
                            'name' => $item->name,
                            'x' => $index * 100,
                            'y' => 0
                        ];
                    })->toArray()
                ]
            ]);

            // 6. Verify creation
            if (!$room->exists) {
                throw new \Exception("Room creation failed!");
            }

            // 7. Add to inventory
            $user->furniture()->attach($defaultFurniture->pluck('id'), [
                'is_placed' => true
            ]);

            // 8. Output success
            $this->command->info("Test user created with ID: {$user->id}");
            $this->command->info("Room created with ID: {$room->id}");
        });
    }

    protected function createDefaultFurnitureIfMissing()
    {
        if (Furniture::where('is_default', true)->doesntExist()) {
            $this->call(FurnitureCatalogSeeder::class);
            $this->command->info('Default furniture created');
        }
    }
}