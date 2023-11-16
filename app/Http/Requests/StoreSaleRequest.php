<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
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
            'date' => 'required',
            'customer_id' => 'required',
            'brand_id' => 'required',
            'tracking_number' => 'required',
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
            'date.required' => 'Please select the date',
            'customer_id.required' => 'Please select the customer',
            'brand_id.required' => 'Please select the brand',
            'tracking_number' => 'Please enter the tracking number',
        ];
    }
}
