<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

use Symfony\Component\HttpFoundation\Response;


class StoreSubscriptionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }

    protected function failedValidation(Validator $validator) : JsonResponse
    {
        throw new HttpResponseException(
            response()->json(['msg' => 'Failed email validation'], Response::HTTP_CONFLICT)
        );
    }
}
