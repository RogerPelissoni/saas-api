<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
  public function rules(): array
  {
    return [
      // profile fields
      // 'name' => 'required|string|max:255',
      // 'description' => 'nullable|string|max:1000',

      // permissions array
      // 'permissions' => 'sometimes|array',
      // 'permissions.*.resource_id' => 'required_with:permissions|integer|exists:resource,id',
      // 'permissions.*.permission_level' => 'nullable|integer|min:1',
      // 'permissions.*.profile_permission_id' => 'nullable|integer|exists:profile_permission,id',
    ];
  }

  public function messages(): array
  {
    return [
      // 'permissions.*.resource_id.exists' => 'Recurso inexistente.',
      // 'permissions.*.profile_permission_id.exists' => 'Permissão de perfil inexistente.',
    ];
  }
}
