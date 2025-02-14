<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BrandsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Brand A',
                'description' => 'Description for Brand A',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Brand B',
                'description' => 'Description for Brand B',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Add more data as needed
        ];

        // Uncomment the line below if you want to delete existing records before seeding
        // $this->db->table('brands')->truncate();

        $this->db->table('brands')->insertBatch($data);
    }
}
