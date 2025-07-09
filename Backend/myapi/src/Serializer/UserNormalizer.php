<?php
namespace App\Serializer;

use App\Entity\User;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserNormalizer implements NormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof User;
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId(),
            'email' => $object->getEmail(),
        ];
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            User::class => true,
        ];
    }

}
