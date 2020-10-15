<?php

use Illuminate\Database\Seeder;
use App\Vendor;

class VendorCircleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $vendors = Vendor::where('color_status','#ef9a9a;')->get();
        foreach($vendors as $vendor){
            $vendor->color_status = '#e57373';
            $vendor->update();
        }

        $vendors = Vendor::where('color_status','#ffcc80;')->get();
        foreach($vendors as $vendor){
            $vendor->color_status = '#ffa726';
            $vendor->update();
        }


        $vendors = Vendor::where('color_status','#fff59d;')->get();
        foreach($vendors as $vendor){
            $vendor->color_status = '#ffee58';
            $vendor->update();
        }


        $vendors = Vendor::where('color_status','#90caf9;')->get();
        foreach($vendors as $vendor){
            $vendor->color_status = '#64b5f6';
            $vendor->update();
        }

        $vendors = Vendor::where('color_status','#c8e6c9;')->get();
        foreach($vendors as $vendor){
            $vendor->color_status = '#81c784';
            $vendor->update();
        }
    }
}
