<?php

namespace App\Http\Livewire\DashboardChart;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schedule;

class KerjasamaTracker extends Component
{
    public $mockData, $locations = [];

    public function mount()
    {
        $this->mockData = $this->generateMockData(10); // Generate 10 mock data points
    }
    // Function to generate random mock data
    public function generateMockData($num)
    {

        // // Fetch data from the API
        // $response = Http::get('https://672f5c9a229a881691f2b77b.mockapi.io/coordinates');

        // // Check if the response is successful
        // if ($response->successful()) {
        //     $this->locations = $response->json();
        // }

        $names = [
            'John Doe',
            'Jane Smith',
            'Alex Johnson',
            'Chris Lee',
            'Katie Brown',
            'David Wilson',
            'Emily Davis',
            'Michael Clark',
            'Sarah Martinez',
            'James Walker'
        ];

        $mockData = [];
        for ($i = 0; $i < $num; $i++) {
            $name = $names[array_rand($names)];
            $latitude = rand(-90, 90) + mt_rand() / mt_getrandmax(); // Random latitude between -90 and 90
            $longitude = rand(-180, 180) + mt_rand() / mt_getrandmax(); // Random longitude between -180 and 180
            $mockData[] = [
                'name' => $name,
                'latitude' =>  $this->randomLatitude(),
                'longitude' => $this->randomLongitude(),
                'id' => (string)($i + 1)
            ];
        }

        return $mockData;
    }

    private function randomLatitude()
    {
        return rand(-90, 90) + (rand(0, 9999) / 10000); // Random latitude from -90 to 90
    }

    private function randomLongitude()
    {
        return rand(-180, 180) + (rand(0, 9999) / 10000); // Random longitude from -180 to 180
    }

    public function render()
    {
        return view('livewire.dashboard-chart.kerjasama-tracker', [
            'mockData' => $this->mockData
        ]);
    }
}
