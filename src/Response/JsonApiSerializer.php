<?php

namespace App\Response;

use League\Fractal\Serializer\JsonApiSerializer as BaseJsonApiSerializer;

/**
 * Extended JsonApiSerializer that will allow to use multiple resource types in same response
 */
class JsonApiSerializer extends BaseJsonApiSerializer
{
    /**
     * Another mandatory field that must be always present in data. Element with this key must contain resource type value.
     */
    const RESOURCE_TYPE_FIELD = 'resource_type';

    public function item(string $resourceKey, array $data): array
    {
        if (empty($resourceKey)) {
            $resourceKey = $this->getResourceTypeFromData($data);
        }

        // remove to not have it in attributes array
        unset($data[self::RESOURCE_TYPE_FIELD]);

        return parent::item($resourceKey, $data);
    }

    private function getResourceTypeFromData(array $data): string
    {
        if (!array_key_exists(self::RESOURCE_TYPE_FIELD, $data)) {
            throw new \InvalidArgumentException(sprintf("Data must contain '%s' element", self::RESOURCE_TYPE_FIELD));
        }

        return $data[self::RESOURCE_TYPE_FIELD];
    }

    public function getMandatoryFields(): array
    {
        return array_merge(parent::getMandatoryFields(), [self::RESOURCE_TYPE_FIELD]);
    }

    /**
     * @param mixed[] $includedData
     * @return mixed[]
     */
    public function parseRelationshipsPublic(array $includedData): array
    {
        return $this->parseRelationships($includedData);
    }

    protected function parseRelationships(array $includedData): array
    {
        $relationships = [];

        foreach ($includedData as $key => $inclusion) {
            foreach ($inclusion as $includeKey => $includeObject) {
                $relationships = $this->buildRelationships($includeKey, $relationships, $includeObject, $key);
                if (isset($includeObject['meta'])) {
                    $relationships[$includeKey][$key]['meta'] = $includeObject['meta'];
                }
            }
        }

        return $relationships;
    }

    /**
     * @param $includeKey
     * @param $relationships
     * @param $includeObject
     * @param $key
     *
     * @return array
     */
    private function buildRelationships($includeKey, $relationships, $includeObject, $key)
    {
        $relationships = $this->addIncludekeyToRelationsIfNotSet($includeKey, $relationships);

        if ($this->isNull($includeObject)) {
            $relationship = $this->null();
        } elseif ($this->isEmpty($includeObject)) {
            $relationship = [
                'data' => [],
            ];
        } elseif ($this->isCollection($includeObject)) {
            $relationship = ['data' => []];

            $relationship = $this->addIncludedDataToRelationship($includeObject, $relationship);
        } else {
            $relationship = [
                'data' => [
                    'type' => $includeObject['data']['type'],
                    'id' => $includeObject['data']['id'],
                ],
            ];
        }

        $relationships[$includeKey][$key] = $relationship;

        return $relationships;
    }

    /**
     * @param $includeKey
     * @param $relationships
     *
     * @return array
     */
    private function addIncludekeyToRelationsIfNotSet($includeKey, $relationships)
    {
        if (!array_key_exists($includeKey, $relationships)) {
            $relationships[$includeKey] = [];
            return $relationships;
        }

        return $relationships;
    }

    /**
     * @param $includeObject
     * @param $relationship
     *
     * @return array
     */
    private function addIncludedDataToRelationship($includeObject, $relationship)
    {
        foreach ($includeObject['data'] as $object) {
            $relationship['data'][] = [
                'type' => $object['type'],
                'id' => $object['id'],
            ];
        }

        return $relationship;
    }
}
