<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenggunaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'username' => 'required',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'          => ':attribute Tidak Boleh Kosong',
            'email.required'         => ':attribute Tidak Boleh Kosong',
            'email.unique'           => ':attribute Sudah Terdaftar Gunakan Email Lain',
            'username.required'         => ':attribute Tidak Boleh Kosong',
            'password.required'         => ':attribute Tidak Boleh Kosong',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'Nama Lengkap',
            'email' => 'Email',
            'username' => 'Username',
            'password' => 'Password',
        ];
    }
}
