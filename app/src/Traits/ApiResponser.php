<?php

namespace App\Traits;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

Trait ApiResponser
{
    public function successResponse($data = null, $code = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse($data, $code);
    }

    public function formErrorResponse(FormInterface $form): JsonResponse
    {
        $errors = $this->getFormErrorsArray($form);
        return new JsonResponse($errors, Response::HTTP_BAD_REQUEST);
    }

    private function getFormErrorsArray(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors() as $key => $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getFormErrorsArray($child);
            }
        }
        return $errors;
    }
}