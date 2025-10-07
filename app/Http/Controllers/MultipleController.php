<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;

class MultipleController
{
  private array $allowedMethods = [
    'cliente' => [\App\Http\Controllers\ClienteController::class, 'index'],
    'company' => [\App\Http\Controllers\CompanyController::class, 'index'],
    'profile' => [\App\Http\Controllers\ProfileController::class, 'index'],
    'user' => [\App\Http\Controllers\UserController::class, 'index'],
  ];

  public function index(Request $request)
  {
    $requestedModels = $request->input('models', []);

    if (!is_array($requestedModels)) {
      return ResponseHelper::error(message: 'O parâmetro "models" deve ser uma lista');
    }

    $arrReturn = [];

    foreach ($request->signatures as $modelParams) {
      $dsSignature = $modelParams['signature'];

      if (!array_key_exists($dsSignature, $this->allowedMethods)) {
        continue;
      }

      [$controllerClass, $method] = $this->allowedMethods[$dsSignature];

      if ($modelParams['keyValue'] ?? null) {
        $method = 'keyValue';
      }

      try {
        $controller = app($controllerClass);
        $response = $controller->$method($request);

        $arrReturn[$dsSignature] = $response instanceof \Illuminate\Http\JsonResponse
          ? $response->getData(true)
          : $response;

        if (isset($arrReturn[$dsSignature]['data'])) {
          $arrReturn[$dsSignature] = $arrReturn[$dsSignature]['data'];
        }

      } catch (\Throwable $e) {
        info("Erro ao processar {$dsSignature}: " . $e->getMessage());

        $arrReturn[$dsSignature] = [
          'error' => 'Falha ao carregar dados deste recurso'
        ];
      }
    }

    return ResponseHelper::success(data: $arrReturn);
  }
}