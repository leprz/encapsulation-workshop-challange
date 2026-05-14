<?php

declare(strict_types=1);

namespace App\Trading\Exception;

use ErrorException;

class WalletNotEnoughCashErrorException extends ErrorException implements NotEnoughFundsErrorException
{

}
