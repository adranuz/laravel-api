<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Response;

trait ApiResponser {

  protected $status_codes = Response::HTTP_OK;

  public function getStatus() {
      return $this->status_codes;
  }

  protected function forbidden($message = 'Forbidden') {
    return $this->setStatus(Response::HTTP_FORBIDDEN)
      ->respondError($message);
  }

  protected function badRequest($message = 'Bad Request') {
    return $this->setStatus(Response::HTTP_BAD_REQUEST)
      ->respondError($message);
  }

  protected function unprocessable($message = 'Unprocessable Entity') {
    return $this->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->respondError($message);
  }

  protected function unauthorized($message = 'Unauthorized') {
    return $this->setStatus(Response::HTTP_UNAUTHORIZED)
      ->respondError($message);
  }

  protected function notFound($message = 'Not Found') {
    return $this->setStatus(Response::HTTP_NOT_FOUND)
      ->respondError($message);
  }

  protected function customError($message = 'Not Found', $code = Response::HTTP_UNPROCESSABLE_ENTITY) {
    return $this->setStatus($code)
      ->respondErrorCustom($message);
  }

  protected function notContent($message = 'Out') {
    return $this->setStatus(Response::HTTP_NO_CONTENT)
      ->respondError($message);
  }

  protected function created($message = 'Created', $data = null) {
    return $this->setStatus(Response::HTTP_CREATED)
      ->respondSuccess($message, $data);
  }

  protected function setStatus($status_code) {
    $this->status_codes = $status_code;
    return $this;
  }

  protected function respondError($message) {
    return response()->json([
        'error' => [
            'code' => $this->getStatus(),
            'message' => $message
        ]
      ], $this->getStatus());
  }

  protected function respondErrorCustom($message) {
    return response()->json([
        'error' => [
            'code' => $this->getStatus(),
            'message' => $message
        ]
      ], Response::HTTP_UNPROCESSABLE_ENTITY);
  }

  protected function respondSuccess($message, $data = null) {
    return response()->json([
        'success' => [
            'code' => $this->getStatus(),
            'message' => $message
        ],
        'data' => $data
      ], $this->getStatus());
  }

  private function successResponse($data, $code) {
    return response()->json($data, $code);
  }

  protected function errorResponse($message, $code) {
    return response()->json(['error' => $message, 'code' => $code], $code);
  }

  protected function showAll(Collection $collection, $code = 200){
    if ($collection->isEmpty()) {
      return $this->successResponse(['data' => $collection], $code);
    }

    //$collection = $this->cacheResponse($collection);

    return $this->successResponse(['data' => $collection], $code);
  }

  protected function showOne(Model $model, $code = 200){
    return $this->successResponse(['data' => $model], $code);
  }

  protected function showMessage($message, $code = 200){
    return $this->successResponse(['data' => $message], $code);
  }

  protected function cacheResponse($data) {
    $url = request()->url();
    $queryParams = request()->query();

    ksort($queryParams);

    $queryString = \http_build_query($queryParams);

    $fullUrl = '{$url}?{$queryString}';

    return Cache::remember($url, 30, function() use($data) {
      return $data;
    });
  }

}