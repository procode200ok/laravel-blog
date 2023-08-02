<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ApiExceptions extends Exception
{
    // HTTP status code for the exception
   protected $statusCode;

   // Custom message for the exception
   protected $message;

   public function __construct($data = [], $rules = [], $messages = [], $customAttributes = [], $statusCode = null, \Throwable $previous = null)
   {
      $this->message = 'Internal Server Error.';
      $this->statusCode = $statusCode ?? Response::HTTP_INTERNAL_SERVER_ERROR;

      parent::__construct($this->message, $this->statusCode, $previous);

      $this->validateOrFail($data, $rules, $messages, $customAttributes);
   }

   public function render()
   {
      return response()->json(['error' => $this->message], $this->statusCode);
   }

   // Method to handle validation and throw ValidationException inside CustomException
   public function validateOrFail($data, $rules, $messages = [], $customAttributes = [])
   {
      $validator = Validator::make($data, $rules, $messages, $customAttributes);

      if ($validator->fails()) {
         throw new ValidationException($validator);
      }
   }

}
