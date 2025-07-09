<?php
namespace App\Serializer;

use App\Entity\Vault;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class VaultNormalizer implements NormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Vault;
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'code' => $object->getCode(),
        ];
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Vault::class => true,
        ];
    }

}
