<?php

namespace App\Http\Requests\Meterans;

use Illuminate\Foundation\Http\FormRequest;

class MeteranRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return $this->createRules();
        } elseif ($this->isMethod('put')) {
            return $this->updateRules();
        }
    }
    /**
     * Define validation rules to store method for resource creation
     *
     * @return array
     */
    public function createRules(): array
    {
        return [
            'pelanggan_id' => 'required|max:191',
            'periode' => 'required|max:191',
            'bulan' => 'required|string|max:16',
            'awal' => 'required|string|max:16',
            'akhir' => 'required|string|max:16',
        ];
    }

    /**
     * Define validation rules to update method for resource update
     *
     * @return array
     */
    public function updateRules(): array
    {
        return [
            'id_pelanggan' => 'required|string|max:191',
            'periode' => 'required|string|max:191',
            'bulan' => 'required|string|max:16',
            'awal' => 'required|string|max:16',
            'akhir' => 'required|string|max:16',
            'pemakaian' => 'required|string|max:16',
        ];
    }
}
