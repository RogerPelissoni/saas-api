<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
  public function rules(): array
  {
    $isCreate = $this->isMethod('post');

    return [
      // profile fields
      'name' => $isCreate ? 'required|string|max:255' : 'sometimes|required|string|max:255',
      'description' => 'nullable|string|max:1000',

      // permissions array
      'permissions' => 'sometimes|array',
      'permissions.*.resource_id' => 'required_with:permissions|integer|exists:resource,id',
      'permissions.*.permission_level' => 'nullable|integer',
      'permissions.*.profile_permission_id' => 'nullable|integer|exists:profile_permission,id',
    ];
  }

  public function messages(): array
  {
    return [
      'permissions.*.resource_id.exists' => 'Recurso inexistente.',
      'permissions.*.profile_permission_id.exists' => 'Permissão de perfil inexistente.',
    ];
  }
}
