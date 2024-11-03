<?php

namespace Sambu\Ecommerce\Http\Requests\Cart;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['code' => $this->get('country')]);
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $countryTable = app('ecommerce')::getCountryTable();

        return [
            'user_id' => ['required', 'exists:users,id'],
            'country' => ['required', "exists:$countryTable,code"],
            'code' => [
                Rule::exists($countryTable)
                    ->where(fn(Builder $query) => $query->where('active', 1)),
            ],
        ];
    }

    protected function passedValidation(): void
    {
        $this->query->remove('code');
    }

    public function messages(): array
    {
        return [
            'code.exists' => 'The selected country is invalid.'
        ];
    }
}
