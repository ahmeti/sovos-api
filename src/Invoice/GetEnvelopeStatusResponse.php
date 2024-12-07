<?php

namespace Ahmeti\Sovos\Invoice;

class GetEnvelopeStatusResponse
{
    public function __construct(
        public ?string $UUID = null,
        public ?string $IssueDate = null,
        public ?string $DocumentTypeCode = null,
        public ?string $DocumentType = null,
        public ?string $ResponseCode = null,
        public ?string $Description = null,
        public ?string $DocData = null
    ) {}
}