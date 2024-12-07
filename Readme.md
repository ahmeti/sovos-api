﻿# Sovos E-Fatura, E-Arşiv, E-İrsaliye

### Giriş
 - [Kurulum](#kurulum)
 - [Gereksinimler](#gereksinimler)

 ### E-Fatura İşlemleri
 - [E-Fatura Servisi](#e-fatura-servisi)
 - [E-Fatura, E-İrsaliye Kayıtlı Kullanıcılar Listesi (Zip)](#e-fatura-e-i̇rsaliye-kayıtlı-kullanıcılar-listesi-zip)
 - [E-Fatura Kayıtlı Kullanıcılar Sorgulama](#e-fatura-kayıtlı-kullanıcılar-sorgulama)
 - [E-Fatura Gelen/Giden Faturaları Sorgulama](#e-fatura-gelengiden-faturaları-sorgulama)
 - [E-Fatura Gelen/Giden Fatura PDF veya HTML İndirme](#e-fatura-gelengiden-fatura-pdf-veya-html-i̇ndirme)
 - [E-Fatura Gelen/Giden Fatura UBL İndirme](#e-fatura-gelengiden-fatura-ubl-i̇ndirme)
 - [E-Fatura Zarf Sorgulama](#e-fatura-zarf-sorgulama)
 - [E-Fatura Uygulama Yanıtı UBL Oluşturma](#e-fatura-uygulama-yanıtı-ubl-oluşturma)
 - [E-Fatura UBL Oluşturma](#e-fatura-ubl-oluşturma)
 - [E-Fatura Gönderme](#e-fatura-gönderme)

 ### E-Arşiv İşlemleri
 - [E-Arşiv Servisi](#e-arşiv-servisi)
 - [E-Arşiv Kayıtlı Kullanıcılar Listesi (Zip)](#e-arşiv-kayıtlı-kullanıcılar-listesi-zip)
 - [E-Arşiv Oluşturma](#e-arşiv-oluşturma)
 - [E-Arşiv Gönderme](#e-arşiv-gönderme)
 - [E-Arşiv Zarf Gönderme](#e-arşiv-zarf-gönderme)
 - [E-Arşiv İptal Etme](#e-arşiv-i̇ptal-etme)
 - [E-Arşiv Tekrar Tetikleme](#e-arşiv-tekrar-tetikleme)
 - [E-Arşiv İndirme](#e-arşiv-i̇ndirme)
 - [E-Arşiv İmzalama](#e-arşiv-i̇mzalama)

## Kurulum
```sh
composer require "ahmeti/sovos-api:^1.0"
```

## Gereksinimler
 - GuzzleHttp
 - ZipArchive
 - PHP 8.0 veya üzeri

## E-Fatura Servisi

```php

$service = new Ahmeti\Sovos\Api\InvoiceService(
    username: 'WS_KULLANICIADI',
    password: 'WS_SIFRE',
    test: true
);
// Son parametre, TEST ortamında ise true yapabilirsiniz veya boş bırakabilirsiniz.
```

## E-Fatura, E-İrsaliye Kayıtlı Kullanıcılar Listesi (Zip)

```php
$getRawUserList = new Ahmeti\Sovos\Invoice\GetRawUserList(
    Identifier: 'SORGULAYAN_PK', // SORGULAYAN_PK veya SORGULAYAN_GB
    VKN_TCKN: 'SORGULAYAN_VKN_TCKN',
    Role: 'PK' // PK veya GB
);

$response = $service->GetRawUserListRequest($getRawUserList);

file_put_contents('/path/to/zip-file.zip', base64_decode($response->DocData));
```

## E-Fatura Kayıtlı Kullanıcılar Sorgulama
Liste halinde kayıtlı kullanıcılar listesini dönecektir. Fonksiyonun daha detaylı açıklamasını Sovos Web Servis Dökümanından edinebilirsiniz.

```php
$userListRequest = new Ahmeti\Sovos\Invoice\GetUserList(
    Identifier: 'SORGULAYAN_PK', // SORGULAYAN_PK veya SORGULAYAN_GB
    VKN_TCKN: 'SORGULAYAN_VKN_TCKN',
    Role: 'PK', // PK veya GB
    Filter_VKN_TCKN: 'SORGULANAN_VKN_TCKN'
);

$list = $service->GetUserListRequest($userListRequest);
```

## E-Fatura Gelen/Giden Faturaları Sorgulama
Posta kutunuza gelen faturaları listelemek için tetiklenen fonksiyon. Fonksiyon parametreleri ile ilgili detaylı bilgiyi Sovos E-Fatura Dökümanında bulabilirsiniz.

```php
$getUblRequest = new Ahmeti\Sovos\Invoice\GetUblList(
    Identifier: 'SORGULAYAN_PK', // SORGULAYAN_PK veya SORGULAYAN_GB
    VKN_TCKN: 'SORGULAYAN_VKN_TCKN',
    UUID: 'FATURA_UUID',
    DocType: 'INVOICE', // INVOICE veya ENVOLOPE    
    Type: 'INBOUND', // INBOUND veya OUTBOUND
    FromDate: '2020-01-01T00:00:00+03:00',
    ToDate: '2020-01-01T00:00:00+03:00',
    FromDateSpecified: true,
    ToDateSpecified: true
);
$list = $service->GetUblListRequest($getUblRequest);
```

## E-Fatura Gelen/Giden Fatura PDF veya HTML İndirme
Seçmiş olduğunuz faturanın PDF veya HTML çıktısını almanızı sağlar. Parametreler ile ilgili daha detaylı bilgiyi Sovos E-Fatura dökümanından inceleyebilirsiniz.

```php
$getInvoiceRequest = new Ahmeti\Sovos\Invoice\GetInvoiceView(
    UUID: 'FATURA_UUID',
    Identifier: 'SORGULAYAN_PK', // SORGULAYAN_PK veya SORGULAYAN_GB
    VKN_TCKN: 'SORGULAYAN_VKN_TCKN',
    Type: 'INVOICE', // INVOICE veya ENVOLOPE
    DocType: 'PDF' // PDF, PDF_DEFAULT veya HTML
);

$data = $service->GetInvoiceViewRequest($getInvoiceRequest);
```

## E-Fatura Gelen/Giden Fatura UBL İndirme
Seçmiş olduğunuz faturanın UBL çıktısını almanıza yarar. Parametreler için daha detaylı bilgiyi Sovos E-Fatura Dökümanında bulabilirsiniz.

```php
$getUblRequest = new Ahmeti\Sovos\Invoice\GetUbl(
    Identifier: 'SORGULAYAN_PK', // SORGULAYAN_PK veya SORGULAYAN_GB
    VKN_TCKN: 'SORGULAYAN_VKN_TCKN',
    UUID: 'FATURA_UUID',
    DocType: 'INVOICE', // INVOICE veya ENVOLOPE
    Type: 'UBL',
    Parameters: 'DOC_DATA'
);

$data = $service->GetUblRequest($getUblRequest);
```

## E-Fatura Zarf Sorgulama
Seçilen zarfın durumunu vb. durumları sorgulama ve detaylar için kullanılan fonksiyon. Daha detaylı bilgi için Sovos dökümanına göz atınız.

```php
$getEnvelopeRequest = new Ahmeti\Sovos\Invoice\GetEnvelopeStatus(
    Identifier: 'SORGULAYAN_PK', // SORGULAYAN_PK veya SORGULAYAN_GB
    VKN_TCKN: 'SORGULAYAN_VKN_TCKN',
    UUID: 'ZARF_UUID',
    Parameters: 'DOC_DATA' // EK PARAMETRE
);

$data = $service->GetEnvelopeStatusRequest($getEnvelopeRequest);
```

## E-Fatura Uygulama Yanıtı UBL Oluşturma
Örnek bir fatura KABUL uygulama yanıtı örneğidir. Örnekte kullanılan alanlar ve isimler GIB ve Sovos standartlarına göre oluşturulmuştur. Alanların anlamı için GIB ve Sovos dökümanlarını inceleyebilirsiniz.
<details>
    <summary>Örneği incelemek için tıklayınız.</summary>

```php
$appResp = new Ahmeti\Ubl\ApplicationResponse(
    UBLVersionID: '2.1',
    CustomizationID: 'TR1.2',
    ProfileID: 'TICARIFATURA',
    ID: '8e593889-917d-4e45-bef1-41aeff67b2f2',
    UUID: '243639d3-48e6-4b25-a9f2-5a148f855c3e',
    IssueDate: '2021-09-01',
    IssueTime: '00:00:00',
    Note: [],
    Signature: null,
    SenderParty: new Ahmeti\Ubl\SenderParty(
        PartyIdentification: new Ahmeti\Ubl\PartyIdentification(
            ID: ['val' => 'GONDERICI_TCKN_VKN', 'attrs' => ['schemaID="TCKN"']],
        ),
        PartyName: new Ahmeti\Ubl\PartyName(
            Name: 'Ahmet İmamoğlu'
        ),
        PostalAddress: new Ahmeti\Ubl\PostalAddress(
            CitySubdivisionName: 'Nilüfer',
            CityName: 'Bursa',
            Country: new Ahmeti\Ubl\Country(
                Name: 'Türkiye'
            )
        )
    ),
    ReceiverParty: new Ahmeti\Ubl\ReceiverParty(
        PartyIdentification: new Ahmeti\Ubl\PartyIdentification(
            ID: ['val' => 'ALICI_TCKN_VKN', 'attrs' => ['schemaID="TCKN"']],
        ),
        PartyName: new Ahmeti\Ubl\PartyName(
            Name: 'Ahmet İmamoğlu'
        ),
        PostalAddress: new Ahmeti\Ubl\PostalAddress(
            CitySubdivisionName: 'Nilüfer',
            CityName: 'Bursa',
            Country: new Ahmeti\Ubl\Country(
                Name: 'Türkiye'
            )
        )
    ), DocumentResponse: new Ahmeti\Ubl\DocumentResponse(
        Response: new Ahmeti\Ubl\Response(
            ReferenceID: '12345',
            ResponseCode: 'KABUL'
        ),
        DocumentReference: new Ahmeti\Ubl\DocumentReference(
            ID: '8e593889-917d-4e45-bef1-41aeff67b2f2',
            DocumentType: 'FATURA',
            DocumentTypeCode: 'FATURA',
            IssueDate: 'BELGE_TARIHI'
        )
    )
);

$xml = (new Ahmeti\Ubl\Utils\UblInvoice($appResp))->getApplicationResponseXML();
```
</details>

## E-Fatura UBL Oluşturma
Örnek bir E-Fatura oluşturmuş olduk bu oluşturduğumuz faturayı Sovos servislerine ileterek faturalaştırmış olacağız. Dikkat etmemiz gereken nokta Fatura UUID ve XML olarak çıktı verir UUID ile faturayı takip edebilirsiniz oluşan XML'i de Sovos sistemine iletebilirsiniz. Alan detayları için GIB ve Sovos dökümanlarına bakınız.
<details>
    <summary>Örneği incelemek için tıklayınız.</summary>

```php
$docRefences = [];

$uuid = \Bulut\eFaturaUBL\XMLHelper::CreateGUID();

$invoice = new \Bulut\eFaturaUBL\Invoice();
$invoice->UBLVersionID = "2.1"; //uluslararası fatura standardı 2.1
$invoice->CustomizationID = "TR1.2"; //fakat GİB UBLTR olarak isimlendirdiği Türkiye'ye özgü 1.2 efatura formatını kullanıyor.
$invoice->ProfileID = "TICARIFATURA"; //ticari ve temel olarak iki çeşittir. ticari faturalarda sistem yanıtı(application response) döner.
#$invoice->ID = "FIT2017000000021"; //Eğer fatura ID FIT tarafından oluşacak ise, ID alanı boş, CUST_INV_ID alanı dolu gelmelidir. Eğer kullanıcı firma tarafından oluşacak ise, ID alanı dolu CUST_INV_ID alanı boş olarak gönderilmeli.
$invoice->CopyIndicator = "false"; //kopyası mı, asıl süret mi olduğu belirlenir
$invoice->UUID = $uuid; //fatura UUID
$invoice->IssueDate = "FATURA_TARIHI"; //Y-m-d fatura tarihi
$invoice->InvoiceTypeCode = "SATIS"; //gönderilecek fatura çeşidi, satış, iade vs.
$invoice->Note = ["Test not"]; //isteğe bağlı not alanı
$invoice->DocumentCurrencyCode = "TRY"; //efatura para birimi
$invoice->LineCountNumeric = 1;  //fatura kalemlerinin sayısı

//Fatura ID otomatik oluşacak ise bu alanı göndermelisiniz.
$invoice_Document_Refence = new \Bulut\eFaturaUBL\DocumentReference();
$invoice_Document_Refence->ID = \Bulut\eFaturaUBL\XMLHelper::CreateGUID();
$invoice_Document_Refence->IssueDate = date('Y-m-d', strtotime($tarih));
$invoice_Document_Refence->DocumentTypeCode = "CUST_INV_ID";
$docRefences[] = $invoice_Document_Refence;


$invoice->AdditionalDocumentReference = $docRefences;

$invoice_AccountSupplierParty = new \Bulut\eFaturaUBL\AccountingSupplierParty();
$invoice_AccountSupplierParty_Party = new \Bulut\eFaturaUBL\Party();
$invoice_AccountSupplierParty_Party->WebsiteURI = "http://unlembilisim.com";

$invoice_AccountSupplierParty_Party_Identifi = new \Bulut\eFaturaUBL\PartyIdentification();
$invoice_AccountSupplierParty_Party_Identifi->ID = ['val'=> '12345678901', 'attrs' => ['schemeID="VKN"']];
$invoice_AccountSupplierParty_Party->PartyIdentification = $invoice_AccountSupplierParty_Party_Identifi;

$invoice_AccountSupplierParty_Party_Name = new \Bulut\eFaturaUBL\PartyName();
$invoice_AccountSupplierParty_Party_Name->Name = "Orhan Gazi Başlı";
$invoice_AccountSupplierParty_Party->PartyName = $invoice_AccountSupplierParty_Party_Name;

$invoice_AccountSupplierParty_Party_Person = new \Bulut\eFaturaUBL\Person();
$invoice_AccountSupplierParty_Party_Person->FirstName = "Orhan Gazi";
$invoice_AccountSupplierParty_Party_Person->FamilyName = "Başlı";
$invoice_AccountSupplierParty_Party->Person = $invoice_AccountSupplierParty_Party_Person;


$invoice_AccountSupplierParty_Party_PostalAdd = new \Bulut\eFaturaUBL\PostalAddress();
$invoice_AccountSupplierParty_Party_PostalAdd->Room = "kapi no";
$invoice_AccountSupplierParty_Party_PostalAdd->StreetName = "cadde";
$invoice_AccountSupplierParty_Party_PostalAdd->BuildingName = "bina";
$invoice_AccountSupplierParty_Party_PostalAdd->BuildingNumber = "bina no";
$invoice_AccountSupplierParty_Party_PostalAdd->CitySubdivisionName = "mahalle";
$invoice_AccountSupplierParty_Party_PostalAdd->CityName = "şehir";
$invoice_AccountSupplierParty_Party_PostalAdd->PostalZone = "posta kodu";
$invoice_AccountSupplierParty_Party_PostalAdd->Region = "asd";

$invoice_AccountSupplierParty_Party_PostalAdd_Country = new \Bulut\eFaturaUBL\Country();
$invoice_AccountSupplierParty_Party_PostalAdd_Country->Name = "Türkiye";

$invoice_AccountSupplierParty_Party_PostalAdd->Country = $invoice_AccountSupplierParty_Party_PostalAdd_Country;
$invoice_AccountSupplierParty_Party->PostalAddress = $invoice_AccountSupplierParty_Party_PostalAdd;

$invoice_AccountSupplierParty_Party_TaxSchema = new \Bulut\eFaturaUBL\PartyTaxScheme();
$invoice_AccountSupplierParty_Party_TaxSchema_Schema = new \Bulut\eFaturaUBL\TaxScheme();
$invoice_AccountSupplierParty_Party_TaxSchema_Schema->Name = "erciyes";
$invoice_AccountSupplierParty_Party_TaxSchema->TaxScheme = $invoice_AccountSupplierParty_Party_TaxSchema_Schema;
$invoice_AccountSupplierParty_Party->PartyTaxScheme = $invoice_AccountSupplierParty_Party_TaxSchema;

$invoice_AccountSupplierParty_Party_Contact = new \Bulut\eFaturaUBL\Contact();
$invoice_AccountSupplierParty_Party_Contact->Telephone = "telef";
$invoice_AccountSupplierParty_Party_Contact->Telefax = "Telefax";
$invoice_AccountSupplierParty_Party_Contact->ElectronicMail = "ElectronicMail";
$invoice_AccountSupplierParty_Party->Contact = $invoice_AccountSupplierParty_Party_Contact;

$invoice_AccountSupplierParty->Party = $invoice_AccountSupplierParty_Party;

$invoice->AccountingSupplierParty = $invoice_AccountSupplierParty;


// Customer
$invoice_AccountCustomerParty = new \Bulut\eFaturaUBL\AccountingCustomerParty();
$invoice_AccountCustomerParty_Party = new \Bulut\eFaturaUBL\Party();
$invoice_AccountCustomerParty_Party->WebsiteURI = "http://unlembilisim.com";

$invoice_AccountCustomerParty_Party_Identifi = new \Bulut\eFaturaUBL\PartyIdentification();
$invoice_AccountCustomerParty_Party_Identifi->ID = ['val'=> "12345678901", 'attrs' => ['schemeID="VKN"']];
$invoice_AccountCustomerParty_Party->PartyIdentification = $invoice_AccountCustomerParty_Party_Identifi;

$invoice_AccountCustomerParty_Party_Name = new \Bulut\eFaturaUBL\PartyName();
$invoice_AccountCustomerParty_Party_Name->Name = "GIB";
$invoice_AccountCustomerParty_Party->PartyName = $invoice_AccountCustomerParty_Party_Name;

// Müşteri eğer gerçek kişi (şahıs şirketi) ise adı ve soyadı gönderilir.
$invoice_AccountCustomerParty_Party_Person = new \Bulut\eFaturaUBL\Person();
$invoice_AccountCustomerParty_Party_Person->FirstName = "ADI";
$invoice_AccountCustomerParty_Party_Person->FamilyName = "SOYADI";
$invoice_AccountCustomerParty_Party->Person = $invoice_AccountCustomerParty_Party_Person;

$invoice_AccountCustomerParty_Party_PostalAdd = new \Bulut\eFaturaUBL\PostalAddress();
$invoice_AccountCustomerParty_Party_PostalAdd->Room = "kapi no";
$invoice_AccountCustomerParty_Party_PostalAdd->StreetName = "cadde";
$invoice_AccountCustomerParty_Party_PostalAdd->BuildingName = "bina";
$invoice_AccountCustomerParty_Party_PostalAdd->BuildingNumber = "bina no";
$invoice_AccountCustomerParty_Party_PostalAdd->CitySubdivisionName = "mahalle";
$invoice_AccountCustomerParty_Party_PostalAdd->CityName = "şehir";
$invoice_AccountCustomerParty_Party_PostalAdd->PostalZone = "posta kodu";
$invoice_AccountCustomerParty_Party_PostalAdd->Region = "asd";

$invoice_AccountCustomerParty_Party_PostalAdd_Country = new \Bulut\eFaturaUBL\Country();
$invoice_AccountCustomerParty_Party_PostalAdd_Country->Name = "Türkiye";

$invoice_AccountCustomerParty_Party_PostalAdd->Country = $invoice_AccountCustomerParty_Party_PostalAdd_Country;
$invoice_AccountCustomerParty_Party->PostalAddress = $invoice_AccountCustomerParty_Party_PostalAdd;

$invoice_AccountCustomerParty_Party_TaxSchema = new \Bulut\eFaturaUBL\PartyTaxScheme();
$invoice_AccountCustomerParty_Party_TaxSchema_Schema = new \Bulut\eFaturaUBL\TaxScheme();
$invoice_AccountCustomerParty_Party_TaxSchema_Schema->Name = "erciyes";
$invoice_AccountCustomerParty_Party_TaxSchema->TaxScheme = $invoice_AccountCustomerParty_Party_TaxSchema_Schema;
$invoice_AccountCustomerParty_Party->PartyTaxScheme = $invoice_AccountCustomerParty_Party_TaxSchema;

$invoice_AccountCustomerParty_Party_Contact = new \Bulut\eFaturaUBL\Contact();
$invoice_AccountCustomerParty_Party_Contact->Telephone = "telef";
$invoice_AccountCustomerParty_Party_Contact->Telefax = "Telefax";
$invoice_AccountCustomerParty_Party_Contact->ElectronicMail = "ElectronicMail";
$invoice_AccountCustomerParty_Party->Contact = $invoice_AccountCustomerParty_Party_Contact;

$invoice_AccountCustomerParty->Party = $invoice_AccountCustomerParty_Party;

$invoice->AccountingCustomerParty= $invoice_AccountCustomerParty;

$invoice_Allowence = new \Bulut\eFaturaUBL\AllowanceCharge();
$invoice_Allowence->ChargeIndicator = "false";
$invoice_Allowence->Amount = ["val" => "0.01", 'attrs' => ['currencyID="TRY"']];
$invoice->AllowanceCharge = $invoice_Allowence;

$invoice_TaxTotal = new \Bulut\eFaturaUBL\TaxTotal();
$invoice_TaxTotal->TaxAmount = ["val" => "0.01", 'attrs' => ['currencyID="TRY"']];

$invoice_TaxTotal_SubTotal = new \Bulut\eFaturaUBL\TaxSubtotal();
$invoice_TaxTotal_SubTotal->TaxableAmount = ["val" => "0.99", 'attrs' => ['currencyID="TRY"']];
$invoice_TaxTotal_SubTotal->TaxAmount = ["val" => "0.01", 'attrs' => ['currencyID="TRY"']];

$invoice_TaxTotal_SubTotal_Category = new \Bulut\eFaturaUBL\TaxCategory();
$invoice_TaxTotal_SubTotal_Category_Schema = new \Bulut\eFaturaUBL\TaxScheme();
$invoice_TaxTotal_SubTotal_Category_Schema->Name = "KDV";
$invoice_TaxTotal_SubTotal_Category_Schema->TaxTypeCode = "0015";

$invoice_TaxTotal_SubTotal_Category->TaxScheme = $invoice_TaxTotal_SubTotal_Category_Schema;
$invoice_TaxTotal_SubTotal->TaxCategory = $invoice_TaxTotal_SubTotal_Category;
$invoice_TaxTotal->TaxSubtotal = $invoice_TaxTotal_SubTotal;

$invoice->TaxTotal = $invoice_TaxTotal;

$invoice_LegalMonetary = new \Bulut\eFaturaUBL\LegalMonetaryTotal();
$invoice_LegalMonetary->LineExtensionAmount = ["val" => "1", 'attrs' => ['currencyID="TRY"']];
$invoice_LegalMonetary->TaxExclusiveAmount = ["val" => "0.99", 'attrs' => ['currencyID="TRY"']];
$invoice_LegalMonetary->TaxInclusiveAmount = ["val" => "1", 'attrs' => ['currencyID="TRY"']];
$invoice_LegalMonetary->AllowanceTotalAmount = ["val" => "0.01", 'attrs' => ['currencyID="TRY"']];
$invoice_LegalMonetary->PayableAmount = ["val" => "1", 'attrs' => ['currencyID="TRY"']];

$invoice->LegalMonetaryTotal = $invoice_LegalMonetary;

$invoice_line = new \Bulut\eFaturaUBL\InvoiceLine();
$invoice_line->ID = "1";
$invoice_line->InvoicedQuantity = ["val" => "1", 'attrs' => ['unitCode="CMT"']];
$invoice_line->LineExtensionAmount = ["val" => "0.99", 'attrs' => ['currencyID="TRY"']];

$invoice_line_allowence = new \Bulut\eFaturaUBL\AllowanceCharge();
$invoice_line_allowence->ChargeIndicator = "false";
$invoice_line_allowence->MultiplierFactorNumeric = "0.01";
$invoice_line_allowence->Amount = ["val" => "0.01", 'attrs' => ['currencyID="TRY"']];
$invoice_line_allowence->BaseAmount = ["val" => "1", 'attrs' => ['currencyID="TRY"']];
$invoice_line->AllowanceCharge = $invoice_line_allowence;

$invoice_line_taxtotal = new \Bulut\eFaturaUBL\TaxTotal();
$invoice_line_taxtotal->TaxAmount = ["val" => "0.01", 'attrs' => ['currencyID="TRY"']];;

$invoice_line_taxtotal_sub = new \Bulut\eFaturaUBL\TaxSubtotal();
$invoice_line_taxtotal_sub->TaxableAmount = ["val" => "0.99", 'attrs' => ['currencyID="TRY"']];
$invoice_line_taxtotal_sub->TaxAmount = ["val" => "0.01", 'attrs' => ['currencyID="TRY"']];
$invoice_line_taxtotal_sub->Percent = "18";

$invoice_line_taxtotal_sub_category = new \Bulut\eFaturaUBL\TaxCategory();
$invoice_line_taxtotal_sub_category_schema = new \Bulut\eFaturaUBL\TaxScheme();
$invoice_line_taxtotal_sub_category_schema->Name = "KDV";
$invoice_line_taxtotal_sub_category_schema->TaxTypeCode = "0015";

$invoice_line_taxtotal_sub_category->TaxScheme = $invoice_line_taxtotal_sub_category_schema;
$invoice_line_taxtotal_sub->TaxCategory = $invoice_line_taxtotal_sub_category;

$invoice_line_taxtotal->TaxSubtotal = $invoice_line_taxtotal_sub;
$invoice_line->TaxTotal = $invoice_line_taxtotal;


$invoice_line_item = new \Bulut\eFaturaUBL\Item();
$invoice_line_item->Name = "Test Ürün";
$invoice_line->Item = $invoice_line_item;

$invoice_line_price = new \Bulut\eFaturaUBL\Price();
$invoice_line_price->PriceAmount = ["val" => "1", 'attrs' => ['currencyID="TRY"']];
$invoice_line->Price = $invoice_line_price;

$invoice->InvoiceLine = [$invoice_line];

$xml = new \Bulut\eFaturaUBL\XMLHelper($invoice);
```
</details>

## E-Fatura Gönderme
Aşağıda oluşturmuş olduğumuz XML (UBL) dosyası son senaryo olarak faturalaştırmak için Sovos servislerine göndermek için kullandığımız fonksiyon. Burada dikkat edilmesi gereken nokta. Zip dosyası oluşturup bu oluşturduğumuz ZIP dosyası ve fatura UUID aynı olmasıdır ve ZIP dosyasını BASE64 yapıp Sovosya gönderiyoruz ve cevabını alıyoruz.

Genel olarak dikkat etmemiz gerekenler Sovos ve GIB dökümanlarını inceleyerek oradaki isimler ve sınıflarımız aynı isimdedir. UBL oluşturup cevabını alabilirsiniz.

```php
$destination = 'temp/'.$uuid.'.zip';
$zip = new ZipArchive();
if($zip->open($destination,ZIPARCHIVE::CREATE) !== true) {
    return false;
}

$zip->addFromString($uuid.'.xml', $xml->getInvoiceResponseXML());
$zip->close();


$sendUblRequest = new \Ahmeti\Sovos\InvoiceService\SendUBL();
$sendUblRequest->setVKNTCKN("GONDERICI_VKN_TCKN");
$sendUblRequest->setDocType("INVOICE"); // veya APP_RESP
$sendUblRequest->setReceiverIdentifier("ALICI_PK");
$sendUblRequest->setSenderIdentifier("GONDERICI_GB");
$sendUblRequest->setDocData(base64_encode(file_get_contents($destination)));
unlink($destination);

$result = $service->SendUBLRequest($sendUblRequest);
```

## E-Arşiv Servisi

```php

$service = new \Ahmeti\Sovos\Api\ArchiveService(
    username: 'EARSIV_WS_Kullanici',
    password: 'EARSIV_WS_Sifre',
    test: true
);
// Son parametre, TEST ortamında ise true yapabilirsiniz veya boş bırakabilirsiniz.
```

## E-Arşiv Kayıtlı Kullanıcılar Listesi (Zip)
Kayıtlı kullanıcılar listesini ZIP olarak dönüş yapar.

```php
$getDocument = new \Ahmeti\Sovos\Archive\GetUserList(
    vknTckn: 'GONDERICI_VKN_TCKN',
);

$result = $service->GetUserListRequest($getDocument);
```

## E-Arşiv Oluşturma
Örnek E-Arşiv faturası oluşturmak için kullanılan parametre ve değişkenlerin açıklamaları için Sovos E-Arşiv dökümanına veya GIB dökümanına göz atabilirsiniz.
<details>
    <summary>Örneği incelemek için tıklayınız.</summary>

```php
$docRefences = [];

$uuid = \Bulut\eFaturaUBL\XMLHelper::CreateGUID();

$invoice = new \Bulut\eFaturaUBL\Invoice();
$invoice->UBLVersionID = "2.1"; //uluslararası fatura standardı 2.1
$invoice->CustomizationID = "TR1.2"; //fakat GİB UBLTR olarak isimlendirdiği Türkiye'ye özgü 1.2 efatura formatını kullanıyor.
$invoice->ProfileID = "EARSIVFATURA"; //ticari ve temel olarak iki çeşittir. ticari faturalarda sistem yanıtı(application response) döner.
$invoice->ID = "FA02017000000021"; //Eğer fatura ID FIT tarafından oluşacak ise, ID alanı boş, CUST_INV_ID alanı dolu gelmelidir. Eğer kullanıcı firma tarafından oluşacak ise, ID alanı dolu CUST_INV_ID alanı boş olarak gönderilmeli.
$invoice->CopyIndicator = "false"; //kopyası mı, asıl süret mi olduğu belirlenir
$invoice->UUID = $uuid; //fatura UUID
$invoice->IssueDate = "Y-m-d"; //fatura tarihi
$invoice->IssueTime = date('H:i:s');
$invoice->InvoiceTypeCode = "SATIS"; //gönderilecek fatura çeşidi, satış, iade vs.
$invoice->DocumentCurrencyCode = "TRY"; //efatura para birimi
$invoice->LineCountNumeric = 1;  //fatura kalemlerinin sayısı
#$invoice->Note = ["Test not"]; //isteğe bağlı not alanı

//Fatura ID otomatik oluşacak ise bu alanı göndermelisiniz.
$invoice_Document_Refence = new \Bulut\eFaturaUBL\DocumentReference();
$invoice_Document_Refence->ID = \Bulut\eFaturaUBL\XMLHelper::CreateGUID();
$invoice_Document_Refence->IssueDate = "Y-m-d";
$invoice_Document_Refence->DocumentTypeCode = "CUST_INV_ID";
$docRefences[] = $invoice_Document_Refence;


//OUTPUT_TYPE
$invoice_Document_Refence1 = new \Bulut\eFaturaUBL\DocumentReference();
$invoice_Document_Refence1->ID = "0100";
$invoice_Document_Refence1->IssueDate = date('Y-m-d');
$invoice_Document_Refence1->DocumentTypeCode = "OUTPUT_TYPE";
$docRefences[] = $invoice_Document_Refence1;


//EREPSENDT
$invoice_Document_Refence2 = new \Bulut\eFaturaUBL\DocumentReference();
$invoice_Document_Refence2->ID = "KAGIT";
$invoice_Document_Refence2->IssueDate = date('Y-m-d');
$invoice_Document_Refence2->DocumentTypeCode = "EREPSENDT";
$docRefences[] = $invoice_Document_Refence2;


$invoice->AdditionalDocumentReference = $docRefences;

$invoice_signature = new \Bulut\eFaturaUBL\Signature();
$invoice_signature->ID = ['val' => "ALICI_VKN_TCKN", 'attrs' => ['schemeID = "VKN_TCKN"']];

$invoice_signature_party = new \Bulut\eFaturaUBL\SignatoryParty();

$invoice__signature_party_ident = new \Bulut\eFaturaUBL\PartyIdentification();
$invoice__signature_party_ident->ID = ['val' => "ALICI_VKN_TCKN", 'attrs' => ['schemeID = "VKN"']];
$invoice_signature_party->PartyIdentification = $invoice__signature_party_ident;

$invoice__signature_party_postal = new \Bulut\eFaturaUBL\PostalAddress();
$invoice__signature_party_postal->StreetName = "deneme cad";
$invoice__signature_party_postal->BuildingName = "01";
$invoice__signature_party_postal->CitySubdivisionName = "ilce";
$invoice__signature_party_postal->CityName = "il";
$invoice__signature_party_postal->PostalZone = "34000";

$invoice__signature_party_postal_country = new \Bulut\eFaturaUBL\Country();
$invoice__signature_party_postal_country->Name = "TÜRKİYE";
$invoice__signature_party_postal->Country = $invoice__signature_party_postal_country;

$invoice_signature_party->PostalAddress = $invoice__signature_party_postal;
$invoice_signature->SignatoryParty = $invoice_signature_party;

$invoice_signature_digital = new \Bulut\eFaturaUBL\DigitalSignatureAttachment();
$invoice_signature_digital_ext = new \Bulut\eFaturaUBL\ExternalReference();
$invoice_signature_digital_ext->URI = "#Signature";
$invoice_signature_digital->ExternalReference = $invoice_signature_digital_ext;

$invoice_signature->DigitalSignatureAttachment = $invoice_signature_digital;

$invoice->Signature = $invoice_signature;


$invoice_AccountSupplierParty = new \Bulut\eFaturaUBL\AccountingSupplierParty();
$invoice_AccountSupplierParty_Party = new \Bulut\eFaturaUBL\Party();
$invoice_AccountSupplierParty_Party->WebsiteURI = "http://unlembilisim.com";

$invoice_AccountSupplierParty_Party_Identifi = new \Bulut\eFaturaUBL\PartyIdentification();
$invoice_AccountSupplierParty_Party_Identifi->ID = ['val'=> "GONDERICI_VKN_TCKN", 'attrs' => ['schemeID="TCKN"']];
$invoice_AccountSupplierParty_Party->PartyIdentification = $invoice_AccountSupplierParty_Party_Identifi;

$invoice_AccountSupplierParty_Party_Name = new \Bulut\eFaturaUBL\PartyName();
$invoice_AccountSupplierParty_Party_Name->Name = "Orhan Gazi Başlı";
$invoice_AccountSupplierParty_Party->PartyName = $invoice_AccountSupplierParty_Party_Name;

$invoice_AccountSupplierParty_Party_Person = new \Bulut\eFaturaUBL\Person();
$invoice_AccountSupplierParty_Party_Person->FirstName = "Orhan Gazi";
$invoice_AccountSupplierParty_Party_Person->FamilyName = "Başlı";
$invoice_AccountSupplierParty_Party->Person = $invoice_AccountSupplierParty_Party_Person;


$invoice_AccountSupplierParty_Party_PostalAdd = new \Bulut\eFaturaUBL\PostalAddress();
$invoice_AccountSupplierParty_Party_PostalAdd->Room = "kapi no";
$invoice_AccountSupplierParty_Party_PostalAdd->StreetName = "cadde";
$invoice_AccountSupplierParty_Party_PostalAdd->BuildingName = "bina";
$invoice_AccountSupplierParty_Party_PostalAdd->BuildingNumber = "bina no";
$invoice_AccountSupplierParty_Party_PostalAdd->CitySubdivisionName = "mahalle";
$invoice_AccountSupplierParty_Party_PostalAdd->CityName = "şehir";
$invoice_AccountSupplierParty_Party_PostalAdd->PostalZone = "posta kodu";
$invoice_AccountSupplierParty_Party_PostalAdd->Region = "asd";

$invoice_AccountSupplierParty_Party_PostalAdd_Country = new \Bulut\eFaturaUBL\Country();
$invoice_AccountSupplierParty_Party_PostalAdd_Country->Name = "Türkiye";

$invoice_AccountSupplierParty_Party_PostalAdd->Country = $invoice_AccountSupplierParty_Party_PostalAdd_Country;
$invoice_AccountSupplierParty_Party->PostalAddress = $invoice_AccountSupplierParty_Party_PostalAdd;

$invoice_AccountSupplierParty_Party_TaxSchema = new \Bulut\eFaturaUBL\PartyTaxScheme();
$invoice_AccountSupplierParty_Party_TaxSchema_Schema = new \Bulut\eFaturaUBL\TaxScheme();
$invoice_AccountSupplierParty_Party_TaxSchema_Schema->Name = "erciyes";
$invoice_AccountSupplierParty_Party_TaxSchema->TaxScheme = $invoice_AccountSupplierParty_Party_TaxSchema_Schema;
$invoice_AccountSupplierParty_Party->PartyTaxScheme = $invoice_AccountSupplierParty_Party_TaxSchema;

$invoice_AccountSupplierParty_Party_Contact = new \Bulut\eFaturaUBL\Contact();
$invoice_AccountSupplierParty_Party_Contact->Telephone = "telef";
$invoice_AccountSupplierParty_Party_Contact->Telefax = "Telefax";
$invoice_AccountSupplierParty_Party_Contact->ElectronicMail = "ElectronicMail";
$invoice_AccountSupplierParty_Party->Contact = $invoice_AccountSupplierParty_Party_Contact;

$invoice_AccountSupplierParty->Party = $invoice_AccountSupplierParty_Party;

$invoice->AccountingSupplierParty = $invoice_AccountSupplierParty;


// Customer
$invoice_AccountCustomerParty = new \Bulut\eFaturaUBL\AccountingCustomerParty();
$invoice_AccountCustomerParty_Party = new \Bulut\eFaturaUBL\Party();
$invoice_AccountCustomerParty_Party->WebsiteURI = "http://unlembilisim.com";

$invoice_AccountCustomerParty_Party_Identifi = new \Bulut\eFaturaUBL\PartyIdentification();
$invoice_AccountCustomerParty_Party_Identifi->ID = ['val'=> $aliciVkn, 'attrs' => ['schemeID="TCKN"']];
$invoice_AccountCustomerParty_Party->PartyIdentification = $invoice_AccountCustomerParty_Party_Identifi;

$invoice_AccountCustomerParty_Party_Name = new \Bulut\eFaturaUBL\PartyName();
$invoice_AccountCustomerParty_Party_Name->Name = "GIB";
$invoice_AccountCustomerParty_Party->PartyName = $invoice_AccountCustomerParty_Party_Name;

$invoice_AccountCustomerParty_Party_Person = new \Bulut\eFaturaUBL\Person();
$invoice_AccountCustomerParty_Party_Person->FirstName = "Test";
$invoice_AccountCustomerParty_Party_Person->FamilyName = "Test";
$invoice_AccountCustomerParty_Party->Person = $invoice_AccountCustomerParty_Party_Person;


$invoice_AccountCustomerParty_Party_PostalAdd = new \Bulut\eFaturaUBL\PostalAddress();
$invoice_AccountCustomerParty_Party_PostalAdd->Room = "kapi no";
$invoice_AccountCustomerParty_Party_PostalAdd->StreetName = "cadde";
$invoice_AccountCustomerParty_Party_PostalAdd->BuildingName = "bina";
$invoice_AccountCustomerParty_Party_PostalAdd->BuildingNumber = "bina no";
$invoice_AccountCustomerParty_Party_PostalAdd->CitySubdivisionName = "mahalle";
$invoice_AccountCustomerParty_Party_PostalAdd->CityName = "şehir";
$invoice_AccountCustomerParty_Party_PostalAdd->PostalZone = "posta kodu";
$invoice_AccountCustomerParty_Party_PostalAdd->Region = "asd";

$invoice_AccountCustomerParty_Party_PostalAdd_Country = new \Bulut\eFaturaUBL\Country();
$invoice_AccountCustomerParty_Party_PostalAdd_Country->Name = "Türkiye";

$invoice_AccountCustomerParty_Party_PostalAdd->Country = $invoice_AccountCustomerParty_Party_PostalAdd_Country;
$invoice_AccountCustomerParty_Party->PostalAddress = $invoice_AccountCustomerParty_Party_PostalAdd;

$invoice_AccountCustomerParty_Party_TaxSchema = new \Bulut\eFaturaUBL\PartyTaxScheme();
$invoice_AccountCustomerParty_Party_TaxSchema_Schema = new \Bulut\eFaturaUBL\TaxScheme();
$invoice_AccountCustomerParty_Party_TaxSchema_Schema->Name = "erciyes";
$invoice_AccountCustomerParty_Party_TaxSchema->TaxScheme = $invoice_AccountCustomerParty_Party_TaxSchema_Schema;
$invoice_AccountCustomerParty_Party->PartyTaxScheme = $invoice_AccountCustomerParty_Party_TaxSchema;

$invoice_AccountCustomerParty_Party_Contact = new \Bulut\eFaturaUBL\Contact();
$invoice_AccountCustomerParty_Party_Contact->Telephone = "telef";
$invoice_AccountCustomerParty_Party_Contact->Telefax = "Telefax";
$invoice_AccountCustomerParty_Party_Contact->ElectronicMail = "ElectronicMail";
$invoice_AccountCustomerParty_Party->Contact = $invoice_AccountCustomerParty_Party_Contact;

$invoice_AccountCustomerParty->Party = $invoice_AccountCustomerParty_Party;

$invoice->AccountingCustomerParty= $invoice_AccountCustomerParty;

$invoice_TaxTotal = new \Bulut\eFaturaUBL\TaxTotal();
$invoice_TaxTotal->TaxAmount = ["val" => "0.01", 'attrs' => ['currencyID="TRY"']];

$invoice_TaxTotal_SubTotal = new \Bulut\eFaturaUBL\TaxSubtotal();
$invoice_TaxTotal_SubTotal->TaxableAmount = ["val" => "0.99", 'attrs' => ['currencyID="TRY"']];
$invoice_TaxTotal_SubTotal->TaxAmount = ["val" => "0.01", 'attrs' => ['currencyID="TRY"']];

$invoice_TaxTotal_SubTotal_Category = new \Bulut\eFaturaUBL\TaxCategory();
$invoice_TaxTotal_SubTotal_Category_Schema = new \Bulut\eFaturaUBL\TaxScheme();
$invoice_TaxTotal_SubTotal_Category_Schema->Name = "KDV";
$invoice_TaxTotal_SubTotal_Category_Schema->TaxTypeCode = "0015";

$invoice_TaxTotal_SubTotal_Category->TaxScheme = $invoice_TaxTotal_SubTotal_Category_Schema;
$invoice_TaxTotal_SubTotal->TaxCategory = $invoice_TaxTotal_SubTotal_Category;
$invoice_TaxTotal->TaxSubtotal = $invoice_TaxTotal_SubTotal;

$invoice->TaxTotal = $invoice_TaxTotal;

$invoice_LegalMonetary = new \Bulut\eFaturaUBL\LegalMonetaryTotal();
$invoice_LegalMonetary->LineExtensionAmount = ["val" => "1", 'attrs' => ['currencyID="TRY"']];
$invoice_LegalMonetary->TaxExclusiveAmount = ["val" => "0.99", 'attrs' => ['currencyID="TRY"']];
$invoice_LegalMonetary->TaxInclusiveAmount = ["val" => "1", 'attrs' => ['currencyID="TRY"']];
$invoice_LegalMonetary->PayableAmount = ["val" => "1", 'attrs' => ['currencyID="TRY"']];

$invoice->LegalMonetaryTotal = $invoice_LegalMonetary;

$invoice_line = new \Bulut\eFaturaUBL\InvoiceLine();
$invoice_line->ID = "1";
$invoice_line->InvoicedQuantity = ["val" => "1", 'attrs' => ['unitCode="CMT"']];
$invoice_line->LineExtensionAmount = ["val" => "0.99", 'attrs' => ['currencyID="TRY"']];


$invoice_line_item = new \Bulut\eFaturaUBL\Item();
$invoice_line_item->Name = "Test Ürün";
$invoice_line->Item = $invoice_line_item;

$invoice_line_price = new \Bulut\eFaturaUBL\Price();
$invoice_line_price->PriceAmount = ["val" => "1", 'attrs' => ['currencyID="TRY"']];
$invoice_line->Price = $invoice_line_price;

$invoice->InvoiceLine = [$invoice_line];

$xml = new \Bulut\eFaturaUBL\XMLHelper($invoice);
```
</details>

## E-Arşiv Gönderme
Oluşturmuş olduğumuz E-Arşiv XML'ini Sovos sistemlerine göndermek için kullandığımız fonksiyon.

```php
$destination = 'temp/'.$rand.'.zip';
$rand = rand(1000,9999);
$zip = new ZipArchive();
if($zip->open($destination,ZIPARCHIVE::CREATE) !== true) {
    return false;
}

$zip->addFromString($uuid.'.xml', $xml);
$zip->close();

$sendUblRequest = new \Ahmeti\Sovos\Archive\SendInvoice(
    senderID: 'GONDERICI_VKN_TCKN',
    hash: md5_file($destination),
    fileName: $rand.'.zip',
    docType: 'XML',
    binaryData: base64_encode(file_get_contents($destination)),
    customizationParams: [new \Ahmeti\Sovos\Archive\CustomizationParam(
        paramName: 'BRANCH',
        paramValue: 'default'
    )],
    responsiveOutput: new \Ahmeti\Sovos\Archive\responsiveOutput(
        outputType: 'PDF'
    ) 
);

$result = $service->SendInvoiceRequest($sendUblRequest);
```

## E-Arşiv Zarf Gönderme
Detaylar için Sovos E-Arşiv dökümanını inceleyebilirsiniz.

```php
$destination = 'temp/'.$rand.'.zip';
$rand = rand(1000,9999);
$zip = new ZipArchive();
if($zip->open($destination,ZIPARCHIVE::CREATE) !== true) {
    return false;
}

$zip->addFromString($uuid.'.xml', $xml);
$zip->close();


$sendUblRequest = new \Ahmeti\Sovos\ArchiveService\SendEnvelope();
$sendUblRequest->setSenderID("GONDERICI_VKN_TCKN");
$sendUblRequest->setHash(md5_file($destination));
$sendUblRequest->setFileName($rand.'.zip');
$sendUblRequest->setDocType("XML");
$sendUblRequest->setBinaryData(base64_encode(file_get_contents($destination)));

$custParam = new \Ahmeti\Sovos\ArchiveService\CustomizationParam();
$custParam->paramName = "BRANCH";
$custParam->paramValue = "default";
$sendUblRequest->setCustomizationParams([$custParam]);

$result = $service->SendEnvelopeRequest($sendUblRequest);
```

## E-Arşiv İptal Etme
Gerekli alanları doldurarak faturayı iptal edebiliriz. Değişkenleri Sovos dökümanından kontrol edebilirsiniz.

```php
$getDocument = new \Ahmeti\Sovos\ArchiveService\InvoiceCancelInfoTypeList();

$getDocument->setInvoiceId("INVOICE_NUMBER");
$getDocument->setVkn("GONDERICI_VKN");
$getDocument->setBranch("GONDEREN_SUBE");
$getDocument->setTotalAmount("FATURA_TUTARI");
$getDocument->setCancelDate("Y-m-d");
$getDocument->setCustInvID("CUST_INV_ID");

$cancelService = new \Ahmeti\Sovos\ArchiveService\CancelInvoice();
$cancelService->setInvoiceCancelInfoTypeList([$getDocument]);
$resutl = $service->CancelInvoiceRequest($cancelService);
```

## E-Arşiv Tekrar Tetikleme
Gönderilmiş bir faturayı tekrar iletmek için kullanılan fonksiyon CustomParameters için Sovos dökümanlarına göz atınız.

```php
$getDocument = new \Ahmeti\Sovos\ArchiveService\RetriggerOperation();
$getDocument->setVKN("GONDERICI_VKN_TCKN");
$getDocument->setBranch("GONDERICI_SUBE");
$getDocument->setInvoiceID("FATURA_NUMARASI");
$getDocument->setInvoiceUUID("FATURA_UUID");

$cust = [];
$customParams = [];
foreach($customParams as $key => $val){
    $name = $val;
    if($name != ""){
        $custObj = new \Ahmeti\Sovos\ArchiveService\CustomizationParam();
        $custObj->paramName = $name;
        $custObj->paramValue = $_POST['paramValue'][$key];
        $cust[] = $custObj;
    }
}
$getDocument->setCustomizationParams($cust);
$result = $service->GetRetriggerOperationRequest($getDocument);
```

## E-Arşiv İndirme
Fonksiyonu tetikleyerek göndermiş olduğunuz faturanın görselini indirebilirsiniz.

```php
$getDocument = new \Ahmeti\Sovos\ArchiveService\GetInvoiceDocument();
$getDocument->setUUID("FATURA_UUID");
$getDocument->setVkn("GONDERICI_VKN");
$getDocument->setInvoiceNumber("FATURA_NUMARASI");
$getDocument->setCustInvId("CUST_INV_ID");
$getDocument->setOutputType("CIKTI_TURU"); // XML, UBL

$result = $service->GetInvoiceDocumentRequest($getDocument);
```

## E-Arşiv İmzalama
Fonksiyonu tetikleyerek imzalama işlemi gerçekleştirebilirsiniz. SDK'da kullanılan tüm fonksiyon ve değişken isimleri Sovos ve GIB sistemine uygundur. Sovos ve GIB dökümanlarını inceleyerek kolaylıkla entegrasyon sağlayabilirsiniz.

```php
$getDocument = new \Ahmeti\Sovos\ArchiveService\GetSignedInvoice();
$getDocument->setUUID("FATURA_UUID");
$getDocument->setVkn("GONDERICI_VKN");
$getDocument->setInvoiceNumber("FATURA_NUMARASI");
$getDocument->setCustInvId("CUST_INV_ID");

$resutl = $service->GetSignedInvoiceRequest($getDocument);
```
