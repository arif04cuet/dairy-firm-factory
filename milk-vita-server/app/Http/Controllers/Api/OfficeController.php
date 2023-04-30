<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    /**
     * ALL OFFICE SYNCHRONIZE TO LOCAL OFFICE
     *
     * @return \Illuminate\Http\Response
     */
    public function synchronize()
    {
        $offices = ReadDashboardOffices(10);
        $offices = collect($offices)->groupBy('parent.id')->toArray();

        // 
        if($offices && array_key_exists(10, $offices))
        {
            foreach($offices[10] as $key=>$row){
                \App\Models\ProcessingPlant::updateOrCreate(['office_id'=>$row['id']], 
                [
                    'processing_plant_name' => $row['name']['bn'],
                    'office_id'             => $row['id'],
                ]);
            }

            // UNSET PROCESSING PLANTS
            unset($offices[10]);

            // FETCH ALL CHILLING PLANT AND CREATE NEW ONE
            foreach($offices as $key=>$chilling_plants)
            {
                $processing_plant = \App\Models\ProcessingPlant::where('office_id', $key)->first();

                if(!empty($processing_plant->id) && is_array($chilling_plants))
                {
                    foreach($chilling_plants as $plant){
                        \App\Models\ChillingPlant::updateOrCreate(['office_id'=>$plant['id']], 
                        [
                            'office_id'             => $plant['id'],
                            'chilling_plant_name'   => $plant['name']['bn'],
                            'processing_plant_id'   => $processing_plant->id,
                        ]);
                    }
                }
            }
            return 1;
        }
        return 0;
    }
}
