# Tradedoubler API client

[![Latest Stable Version](https://img.shields.io/packagist/v/whitelabeled/tradedoubler-api-client.svg)](https://packagist.org/packages/whitelabeled/tradedoubler-api-client)
[![Total Downloads](https://img.shields.io/packagist/dt/whitelabeled/tradedoubler-api-client.svg)](https://packagist.org/packages/whitelabeled/tradedoubler-api-client)
[![License](https://img.shields.io/packagist/l/whitelabeled/tradedoubler-api-client.svg)](https://packagist.org/packages/whitelabeled/tradedoubler-api-client)

Library to retrieve sales from the TradeDoubler reporting API.
This API is intended for publishers who would like to automatically import transaction data.

Usage:

```php
<?php
require 'vendor/autoload.php';

$client = new \whitelabeled\TradeDoublerApi\TradeDoublerClient('1234567', 'abcdef1234567890abcdef1234567890');

$transactions = $client->getTransactions(new DateTime('2017-03-05'), new DateTime('2017-03-07'));

print_r($transactions);
/*
 * Returns:
Array
(
    [0] => whitelabeled\TradeDoublerApi\Transaction Object
        (
            [generatedId] => gen-194394-966b7b63bbeb1b861f83633479e53282ac5a7e04
            [transactionDate] => DateTime Object
                (
                    [date] => 2017-03-05 15:10:03.000000
                    [timezone_type] => 3
                    [timezone] => UTC
                )

            [clickDate] => DateTime Object
                (
                    [date] => 2017-03-05 14:55:23.000000
                    [timezone_type] => 3
                    [timezone] => UTC
                )

            [lastModifiedDate] => DateTime Object
                (
                    [date] => 2017-04-11 12:09:42.000000
                    [timezone_type] => 3
                    [timezone] => Europe/Berlin
                )

            [program] => Acme Inc.
            [programId] => 123456
            [orderNr] => 984754
            [leadNr] => 
            [eventId] => 344955
            [eventName] => Year 1
            [deviceType] => 
            [status] => P
            [statusReason] => 
            [epi1] => 
            [epi2] => 
            [commission] => 50.0
            [orderValue] => 0.0
            [mediaId] => 4394849
            [mediaName] => Your website
        )

    [1] => whitelabeled\TradeDoublerApi\Transaction Object
        (
            [generatedId] => gen-194394-d5db65b678a9c5aa77e8a2fff7f522aa928c7d69
            [transactionDate] => DateTime Object
                (
                    [date] => 2017-03-06 12:25:15.000000
                    [timezone_type] => 3
                    [timezone] => UTC
                )

            [clickDate] => DateTime Object
                (
                    [date] => 2017-01-27 10:43:51.000000
                    [timezone_type] => 3
                    [timezone] => UTC
                )

            [lastModifiedDate] => DateTime Object
                (
                    [date] => 2017-04-11 12:09:42.000000
                    [timezone_type] => 3
                    [timezone] => Europe/Berlin
                )

            [program] => Acme Inc.
            [programId] => 123456
            [orderNr] => 985352
            [leadNr] => 
            [eventId] => 344955
            [eventName] => Year 1
            [deviceType] => Mobiel
            [status] => P
            [statusReason] => 
            [epi1] => m_95l9TeA2KuuVSV7xMsPCDessuEItoUtuxwG9pRoJvtNSYzWA
            [epi2] => 
            [commission] => 50.0
            [orderValue] => 0.0
            [mediaId] => 4394849
            [mediaName] => Your website
        )
)
*/
```

## License

© Goldlabeled BV

MIT license, see [LICENSE.txt](LICENSE.txt) for details.