<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required',Rule::unique('brands')->ignore($this->brand),'max:45']
        ];
    }
    public function messages()
    {
        // dd($this->brand->id);
        return [
            'name.required' => 'il nome è obbligatorio',
            'name.unique' => "{$this->brand->id} il nome esiste già",
            'name.max' => 'il nome non può superare i :max caratteri',
        ];
    }
}
