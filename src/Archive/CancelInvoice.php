<?php

namespace Ahmeti\Sovos\Archive;

class CancelInvoice
{
    public function __construct(
        public string $soapAction = 'cancelInvoice',
        public string $methodName = 'invoiceCancellationServiceRequestType',
        public bool $prefix = false,
        public string $namespace = 'http://fitcons.com/earchive/invoicecancellation',
        public ?string $invoiceCancelInfoTypeList = null
    ) {}
}
