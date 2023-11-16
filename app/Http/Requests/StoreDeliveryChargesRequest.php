<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeliveryChargesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shipment_type_id' => 'required',
            'zone_no' => 'required',
            'fuel_percentage' => 'required',
            'gst_percentage' => 'required',
            'additional_kg_charges' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'shipment_type_id.required' => 'Please select the shipment type',
            'zone_no.required' => 'Please select the zone',
            'fuel_percentage.required' => 'Please enter the fuel percentage',
            'gst_percentage.required' => 'Please enter the GST percentage',
            'additional_kg_charges.required' => 'Please enter the additional kg charges',
        ];
    }
}
