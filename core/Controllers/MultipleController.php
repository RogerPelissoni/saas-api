<?php

namespace Core\Controllers;

use App\Config\MultipleRoutesConfig;
use Core\Helpers\ResponseHelper;
use Illuminate\Http\Request;

class MultipleController
{
  public function index(Request $request)
  {
    $allowedMethods = MultipleRoutesConfig::get();
    $requestedModels = $request->input('models', []);

    if (!is_array($requestedModels)) {
      return ResponseHelper::error(message: 'O parâmetro "models" deve ser uma lista');
    }

    $arrReturn = [];

    foreach ($request->signatures as $modelParams) {
      $dsSignature = $modelParams['signature'];

      if (!array_key_exists($dsSignature, $allowedMethods)) {
        throw new \Exception("Recurso $dsSignature não disponível");
      }

      [$controllerClass, $method] = $allowedMethods[$dsSignature];

      if ($modelParams['keyValue'] ?? null) {
        $method = 'keyValue';
      }

      try {
        $controller = app($controllerClass);
        $response = $controller->$method($request);

        $arrReturn[$dsSignature] = $response instanceof \Illuminate\Http\JsonResponse
          ? $response->getData(true)
          : $response;

        $arrReturn[$dsSignature] = $arrReturn[$dsSignature]['data']['data'] ?? $arrReturn[$dsSignature]['data'] ?? $arrReturn[$dsSignature];

      } catch (\Throwable $e) {
        info("Erro ao processar $dsSignature: " . $e->getMessage());

        $arrReturn[$dsSignature] = [
          'error' => "Falha ao carregar dados do recurso $dsSignature"
        ];
      }
    }

    return ResponseHelper::success(data: $arrReturn);
  }
}