<?php
namespace App\EventListener;


use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class ExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        switch (true) {
            case $exception instanceof UnprocessableEntityHttpException
                && $exception->getPrevious() instanceof ValidationFailedException:
                $event->setResponse($this->handleValidationFailedException($exception));
                return;

            case $exception instanceof NotFoundHttpException:
                $event->setResponse($this->handleNotFoundException($exception));
                return;

            case $exception instanceof BadRequestHttpException:
                $event->setResponse($this->handleBadRequestException($exception));
                return;

            case $exception instanceof \TypeError:
                $event->setResponse($this->handleTypeError($exception));
                return;

            default:
                return;
        }


    }

    private function handleValidationFailedException(\Throwable $exception): JsonResponse
    {
            /** @var ValidationFailedException $validationException */
            $validationException = $exception->getPrevious();
            $violations = [];

            foreach ($validationException->getViolations() as $violation) {
                $violations[] = [
                    'field' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                ];
            }

            return new JsonResponse([
                'error' => 'Validation failed',
                'violations' => $violations,
            ], 422);   
    }

    private function handleNotFoundException(\Throwable $exception): JsonResponse
    {
        return new JsonResponse([
            'error' => 'Resource not found',
            'message' => $exception->getMessage(),
        ], 404);
    }

    
    private function handleBadRequestException(\Throwable $exception): JsonResponse
    {
        return new JsonResponse([
            'error' => 'Invalid request format',
            'message' => $exception->getMessage(),
        ], 400);
    }

    private function handleTypeError(\Throwable $exception): JsonResponse
    {
        return new JsonResponse([
            'error' => 'Unexpected data type in request',
            'message' => $exception->getMessage(),
        ], 400);
    }

}