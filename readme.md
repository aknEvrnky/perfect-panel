# AknEvrnky\PerfectPanel\Client

AknEvrnky\PerfectPanel\Client is a PHP library for interacting with the PerfectPanel API. The library provides a simple, fluent PHP interface for communicating with PerfectPanel.

## Installation

The package can be installed via composer:

```bash
composer require aknevrnky/perfect-panel
```

## Usage
The library provides several methods to interact with the PerfectPanel API.
First, you need to instantiate the `PerfectPanel` class with your API URI and API Key:

```php
use AknEvrnky\PerfectPanel\Client\PerfectPanel;

$perfectPanel = new PerfectPanel($apiUri, $apiKey);
```

### Get Available Services

```php
$services = $perfectPanel->getServices();
```

### Create an Order
```php
$orderID = $perfectPanel->order($service, $link, $quantity);
```

### Get Order Status
```php
$status = $perfectPanel->status($orderID);
```

### Get Multiple Order Statuses
```php
$orderIDs = [1, 2, 3];
$statuses = $perfectPanel->statuses($orderIDs);

$otherIds = '3,76,32';
$statuses = $perfectPanel->statuses($otherIds);
```

### Check Balance
```php
$balance = $perfectPanel->balance();
```

### Refill Order
```php
$perfectPanel->refill($orderID);
```

### Check Refill Status
```php
$perfectPanel->refillStatus($orderID);
```

## Error Handling
The library will throw an `ApiErrorException` if the API returns an error.
You should use try-catch blocks to handle these exceptions.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
AknEvrnky\PerfectPanel\Client is open-sourced software licensed under the MIT license.