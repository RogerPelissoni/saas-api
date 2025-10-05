<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class MultipleController
{
  private array $allowedMethods = [
    'client' => [\App\Http\Controllers\ClientController::class, 'index'],
    'profile' => [\App\Http\Controllers\ProfileController::class, 'index'],
    'user' => [\App\Http\Controllers\UserController::class, 'index'],
  ];

  public function index(Request $request)
  {
    $requestedModels = $request->input('models', []);

    if (!is_array($requestedModels)) {
      return response()->json(['message' => 'O parâmetro "models" deve ser uma lista'], Response::HTTP_BAD_REQUEST);
    }

    $arrReturn = [];

    foreach ($request->models as $modelParams) {
      $dsModel = $modelParams['model'];

      if (!array_key_exists($dsModel, $this->allowedMethods)) {
        continue;
      }

      [$controllerClass, $method] = $this->allowedMethods[$dsModel];

      if ($modelParams['keyValue'] ?? null) {
        $method = 'keyValue';
      }

      try {
        $controller = app($controllerClass);
        $response = $controller->$method();

        $arrReturn[$dsModel] = $response instanceof \Illuminate\Http\JsonResponse
          ? $response->getData(true)
          : $response;

        if (isset($arrReturn[$dsModel]['data'])) {
          $arrReturn[$dsModel] = $arrReturn[$dsModel]['data'];
        }

      } catch (\Throwable $e) {
        info("Erro ao processar {$dsModel}: " . $e->getMessage());

        $arrReturn[$dsModel] = [
          'error' => 'Falha ao carregar dados deste recurso'
        ];
      }
    }

    return response()->json([
      'data' => $arrReturn,
    ]);
  }
}