<?php

namespace App\Services;

use App\Models\Roles;
use App\Models\User;
use App\Models\Rates;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RatesService {

    public static function getData(?int $id = null) {

        if(!is_null($id)) {
            return Rates::with('property_type')->where('id', $id)
                ->first() ?? null;
        }

        return Rates::with('property_type')->get();

    }

    public static function create(array $payload) {

        DB::beginTransaction();
        try {

            Rates::create([
                'property_types_id' => $payload['property_type'],
                'cubic_from' => $payload['cubic_from'],
                'cubic_to' => $payload['cubic_to'],
                'rates' => $payload['rate']
            ]);

            DB::commit();

            return [
                'status' => 'success',
                'message' => 'Water rate added.'
            ];

        } catch (\Exception $e) {
            
            DB::rollBack();

            return [
                'status' => 'error',
                'message' => 'Error occured: ' . $e->getMessage()
            ];
        }

    }

    public static function update(?int $id, array $payload) {

        DB::beginTransaction();

        try {
            
            $updateData = [
                'property_types_id' => $payload['property_type'],
                'cubic_from' => $payload['cubic_from'],
                'cubic_to' => $payload['cubic_to'],
                'rates' => $payload['rate']
            ];

            Rates::where('id', $id)->update($updateData);

            DB::commit();

            return [
                'status' => 'success',
                'message' => 'Water rate  updated.'
            ];

        } catch (\Exception $e) {
            
            DB::rollBack();

            return [
                'status' => 'error',
                'message' => 'Error occured: ' . $e->getMessage()
            ];
        }

    }

    public static function delete(?int $id) {

        DB::beginTransaction();

        try {
            
            $data = Rates::where('id', $id)->first();
                
            $data->delete();

            DB::commit();

            return [
                'status' => 'success',
                'message' => 'Water rate deleted.'
            ];

        } catch (\Exception $e) {
            
            DB::rollBack();

            return [
                'status' => 'error',
                'message' => 'Error occured: ' . $e->getMessage()
            ];
        }

    }


}