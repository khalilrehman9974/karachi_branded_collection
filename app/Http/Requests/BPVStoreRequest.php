<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BPVStoreRequest extends FormRequest
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
            'account_id' => 'required',
            'bank_id' => 'required',
            'credit' => 'required'
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'date.required' => 'Please select the date!',
            'account_id.required' => 'Please select the party!',
            'bank_id.required' => 'Please select the bank!',
            'credit.required' => 'Please enter the amount!',
        ];
    }
}
