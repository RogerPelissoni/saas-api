<?php
namespace Core\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
  public static function success($data = [], string $message = 'Operação efetuada com sucesso'): JsonResponse
  {
    return response()->json([
      'message' => $message,
      'data' => $data,
    ]);
  }

  public static function error(string $message, int $code = 400): JsonResponse
  {
    return response()->json(['error' => $message], $code);
  }
}
