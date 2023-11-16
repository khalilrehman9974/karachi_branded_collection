<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
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
        if ($this->account_type == 'P' || $this->account_type == 'S') {
            return [
                'name' => 'required',
                'mobile_no' => 'required',
                'whatsapp_no' => 'required',
                'city' => 'required',
                'shipping_address' => 'required',
                'mailing_address' => 'required',
                'account_type' => 'required',
            ];
        }
            return [
                'name' => 'required',
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
            'name.required' => 'Please enter the name',
            'mobile_no.required' => 'Please enter the phone number',
            'whatsapp_no.required' => 'Please enter the whatsapp number',
            'city.required' => 'Please enter the city',
            'shipping_address.required' => 'Please enter the mailing address',
            'mailing_address.required' => 'Please enter the shipping address',
            'account_type.required' => 'Please select the account type',
        ];
    }
}
