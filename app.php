<?php
use Commissions\Application\Application;
use Commissions\Infrastructure\TransactionSource\FileTransactions;
use Commissions\Infrastructure\BinDetailsSource\Binlist;
use Commissions\Infrastructure\RateSource\ExchangeRates;
use Commissions\Domain\CommissionCalculation;
use Commissions\Infrastructure\RequestMaker\CurlRequestMaker;
use Commissions\Infrastructure\RequestMaker\FileRequestMaker;
use Commissions\Infrastructure\FileReader;
use Commissions\Domain\Geography;
    
require_once dirname(__FILE__) . '/vendor/autoload.php';

$config = require_once('config.php');


try {
    $inputFile = $argv[1];

    if (!$inputFile) {
        throw new Exception('Please, provide a valid input file');
    }
    
    if (!$config['rates_api_key']) {
        throw new Exception('Please, configure with a valid rate api key');
    }

    $transactions = new FileTransactions(
        new FileReader($inputFile)
    );

    $bins = new Binlist(
        new FileRequestMaker(), 
        new Geography(), 
        $config['bins_api_url']
    );

    $ratesRequestMaker = new CurlRequestMaker(
        ['apikey: ' . $config['rates_api_key'] ]
    );
    
    $rates = new ExchangeRates(
        $ratesRequestMaker,
        $config['rates_api_url']
    );

    $calculation = new CommissionCalculation();

    $app = new Application($transactions, $bins, $rates, $calculation);

    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}

