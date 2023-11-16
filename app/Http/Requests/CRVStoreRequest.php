<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CRVStoreRequest extends FormRequest
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
            'credit' => 'required|numeric',
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
            'account_id.required' => 'Please select the account!',
            'credit.required' => 'Please enter the amount!',
        ];
    }
}
