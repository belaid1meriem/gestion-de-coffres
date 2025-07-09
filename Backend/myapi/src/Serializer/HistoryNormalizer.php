<?php
namespace App\Serializer;

use App\Entity\History;
use App\Serializer\VaultNormalizer;
use App\Serializer\UserNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class HistoryNormalizer implements NormalizerInterface
{
    public function __construct(
        private readonly VaultNormalizer $vaultNormalizer,
        private readonly UserNormalizer $userNormalizer,
    ) {}

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof History;
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId(),
            'code' => $object->getCode(),
            'updatedAt' => $object->getUpdatedAt()?->format('Y-m-d H:i:s'),
            'vault' => $this->vaultNormalizer->normalize($object->getVault(), $format, $context),
            'user' => $this->userNormalizer->normalize($object->getUser(), $format, $context),
        ];
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            History::class => true,
        ];
    }

}
