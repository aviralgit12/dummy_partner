<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas= [
            [
                 "first_name"=> "Jane",
                 "last_name"=> "Smith",
                 "email"=> "jane.smith@example.com",
                 "pet_points"=> "200",
                 "uuid"=> "a1b2c3d4-e5f6-7g8h-9i10-jk11lm12no13"
            ],
            [
                 "first_name"=> "Alice",
                 "last_name"=> "Johnson",
                 "email"=> "alice.johnson@example.com",
                 "pet_points"=> "320",
                 "uuid"=> "b2c3d4e5-f6g7-8h9i-10jk-11lm12no13pq"
            ],
            [
                 "first_name"=> "Robert",
                 "last_name"=> "Brown",
                 "email"=> "robert.brown@example.com",
                 "pet_points"=> "450",
                 "uuid"=> "c3d4e5f6-g7h8-9i10-jk11-lm12no13pqrs"
            ],
            [
                 "first_name"=> "Emily",
                 "last_name"=> "Davis",
                 "email"=> "emily.davis@example.com",
                 "pet_points"=> "500",
                 "uuid"=> "d4e5f6g7-h8i9-10jk-11lm-12no13pqrstuv"
            ],
            [
                 "first_name"=> "Michael",
                 "last_name"=> "Wilson",
                 "email"=> "michael.wilson@example.com",
                 "pet_points"=> "275",
                 "uuid"=> "e5f6g7h8-i9j10-11lm-12no-13pqrstuvwxy"
            ],
            [
                 "first_name"=> "Sarah",
                 "last_name"=> "Taylor",
                 "email"=> "sarah.taylor@example.com",
                 "pet_points"=> "340",
                 "uuid"=> "f6g7h8i9-j10k11-lm12-no13-pqrstuvwxyz"
            ],
            [
                 "first_name"=> "David",
                 "last_name"=> "Anderson",
                 "email"=> "david.anderson@example.com",
                 "pet_points"=> "190",
                 "uuid"=> "g7h8i9j10-k11lm12-no13-pqrstuvwxyz12"
            ],
            [
                 "first_name"=> "Jessica",
                 "last_name"=> "Thomas",
                 "email"=> "jessica.thomas@example.com",
                 "pet_points"=> "460",
                 "uuid"=> "h8i9j10k11-lm12no13-pqrstuvwxyz1234"
            ],
            [
                 "first_name"=> "Daniel",
                 "last_name"=> "Martinez",
                 "email"=> "daniel.martinez@example.com",
                 "pet_points"=> "510",
                 "uuid"=> "i9j10k11lm-12no13pqrst-uvwxyz123456"
            ],
            [
                 "first_name"=> "Sophia",
                 "last_name"=> "Lee",
                 "email"=> "sophia.lee@example.com",
                 "pet_points"=> "310",
                 "uuid"=> "j10k11lm12-n13pqrstuv-wxyz12345678"
            ],
            [
                 "first_name"=> "James",
                 "last_name"=> "Garcia",
                 "email"=> "james.garcia@example.com",
                 "pet_points"=> "390",
                 "uuid"=> "k11lm12no13-pqrstuvwxy-z1234567890"
            ],
            [
                 "first_name"=> "Linda",
                 "last_name"=> "Hernandez",
                 "email"=> "linda.hernandez@example.com",
                 "pet_points"=> "410",
                 "uuid"=> "lm12no13pqr-stuvwxyz123-45678901234"
            ],
            [
                 "first_name"=> "William",
                 "last_name"=> "Lopez",
                 "email"=> "william.lopez@example.com",
                 "pet_points"=> "215",
                 "uuid"=> "no13pqrstuvw-xyz1234567-89012345678"
            ],
            [
                 "first_name"=> "Olivia",
                 "last_name"=> "Clark",
                 "email"=> "olivia.clark@example.com",
                 "pet_points"=> "375",
                 "uuid"=> "pqrstuvwxyz12-3456789012-34567890123"
            ],
            [
                 "first_name"=> "Ethan",
                 "last_name"=> "Hall",
                 "email"=> "ethan.hall@example.com",
                 "pet_points"=> "290",
                 "uuid"=> "qrstuvwxyz123-4567890123-45678901234"
            ],
            [
                 "first_name"=> "Isabella",
                 "last_name"=> "Allen",
                 "email"=> "isabella.allen@example.com",
                 "pet_points"=> "425",
                 "uuid"=> "rstuvwxyz1234-5678901234-56789012345"
            ],
            [
                 "first_name"=> "Andrew",
                 "last_name"=> "Young",
                 "email"=> "andrew.young@example.com",
                 "pet_points"=> "240",
                 "uuid"=> "stuvwxyz12345-6789012345-67890123456"
            ],
            [
                 "first_name"=> "Mia",
                 "last_name"=> "King",
                 "email"=> "mia.king@example.com",
                 "pet_points"=> "280",
                 "uuid"=> "tuvwxyz123456-7890123456-78901234567"
            ],
            [
                 "first_name"=> "Matthew",
                 "last_name"=> "Wright",
                 "email"=> "matthew.wright@example.com",
                 "pet_points"=> "480",
                 "uuid"=> "uvwxyz1234567-8901234567-89012345678"
            ],
            [
                 "first_name"=> "Chloe",
                 "last_name"=> "Scott",
                 "email"=> "chloe.scott@example.com",
                 "pet_points"=> "360",
                 "uuid"=> "vwxyz12345678-9012345678-90123456789"
            ]
            ];

            foreach ($datas as $data) {
                $customer=new Customer();
                $customer->first_name = $data['first_name'];
                $customer->last_name = $data['last_name'];
                $customer->email = $data["email"];
                $customer->pet_point = $data['pet_points'];
                $customer->uuid= $data['uuid'];
                $customer->save();
            }
    }
}
