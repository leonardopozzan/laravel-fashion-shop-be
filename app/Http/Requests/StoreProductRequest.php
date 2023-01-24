<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|unique:products|max:100|min:3',
            'description' => 'nullable',
            'price' => 'required|numeric|between:0, 100',
            'image' => 'nullable|image|max:255',
            'rating' => 'nullable|numeric|between:0, 5',
            'available' => 'required',
            'detail_link' => 'nullable',
            'type_id' => 'required|exists:types,id',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Il nome è obbligatorio.',
            'name.min' => 'Il nome deve essere lungo almeno :min caratteri.',
            'name.max' => 'Il nome non può superare i :max caratteri.',
            'name.unique:products' => 'Il nome esiste già',
            'price.required' => 'Il prezzo è obbligatorio.',
            'price.max' => 'Il prezzo non deve superare :max',
            'price.min' => 'Il prezzo non deve essere minore di :min',
            'rating.max' => 'Il rating non deve superare :max',
            'rating.min' => 'Il rating non deve essere minore di :min',
            'available.required' => 'La disponibilità è obbligatoria.',
            'type_id.required' => 'il campo è richiesto',
            'brand_id.required' => 'il campo è richiesto',
            'category_id.required' => 'il campo è richiesto',
        ];
    }
}
