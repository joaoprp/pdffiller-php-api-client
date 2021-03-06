<?php

namespace PDFfiller\OAuth2\Client\Provider;

use PDFfiller\OAuth2\Client\Provider\Core\Model;
use PDFfiller\OAuth2\Client\Provider\Exceptions\MethodNotSupportedException;

/**
 * Class AdditionalDocument
 * @package PDFfiller\OAuth2\Client\Provider
 *
 * @property string $name
 * @property string $document_request_notification
 * @property string $filename
 * @property string $ip
 * @property int $date_created
 */
abstract class AdditionalDocument extends Model
{
    const DOWNLOAD = 'download';
    const ADDITIONAL_DOCUMENT = 'additional_document';

    /**
     * FillRequestId or SignatureRequestId
     * @var int|null
     */
    protected $requestId = null;

    /**
     * Recipient for SignatureRequest and FilledForm for FillRequest
     * @var int|null
     */
    protected $resourceId = null;

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'name',
            'filename',
            'id',
            'ip',
            'date_created',
            'document_request_notification',
        ];
    }

    /**
     * AdditionalDocument constructor.
     * @param PDFfiller $provider
     * @param int $requestId
     * @param int $resourceId
     * @param array $properties
     */
    public function __construct(PDFfiller $provider, $requestId, $resourceId, $properties = [])
    {
        if (is_string($properties)) {
            $properties = [
                'document_request_notification' => $properties
            ];
        }

        $this->requestId = $requestId;
        $this->resourceId = $resourceId;
        parent::__construct($provider, $properties);
        static::setEntityUri(implode('/', [
            static::getEntityUri(),
            $this->requestId,
            $this->getResourceIdentifier(),
            $this->resourceId,
            self::ADDITIONAL_DOCUMENT,
        ]));
    }

    /**
     * Downloads additional document
     * @param array $parameters
     * @return mixed
     */
    public function download($parameters = [])
    {
        return self::query(
            $this->client,
            [
                $this->id,
                self::DOWNLOAD,
            ],
            $parameters
        );
    }

    /**
     * @inheritdoc
     */
    public static function one(PDFfiller $provider, $id)
    {
        throw new MethodNotSupportedException("Can't get document, see FillRequestForm and SignatureRequestRecipient classes");
    }

    /**
     * @inheritdoc
     */
    public static function all(PDFfiller $provider, array $queryParams = [])
    {
        throw new MethodNotSupportedException("Can't get documents, see FillRequestForm and SignatureRequestRecipient classes");
    }

    /**
     * Returns the resource identifier
     * @return string
     */
    protected abstract function getResourceIdentifier();
}
