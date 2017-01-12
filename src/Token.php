<?php

namespace PDFfiller\OAuth2\Client\Provider;


use PDFfiller\OAuth2\Client\Provider\Core\Model;

/**
 * Class Token
 * @package PDFfiller\OAuth2\Client\Provider
 *
 * @property array $data
 * @property string $hash
 */
class Token extends Model
{
    /** @var string */
    protected static $entityUri = 'token';

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            'id',
            'hash',
            'data',
        ];
    }
}
