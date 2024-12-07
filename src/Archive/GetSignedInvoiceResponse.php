<?php

namespace Ahmeti\Sovos\Archive;

class GetSignedInvoiceResponse
{
    public function __construct(
        public ?string $UUID,
        public ?string $vkn,
        public ?string $invoiceNumber,
        public ?string $Detail,
        public ?string $Hash,
        public ?string $binaryData,
    ) {}
}
