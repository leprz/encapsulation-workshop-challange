<?php

declare(strict_types=1);

namespace App;

use ErrorException;

class WalletNotEnoughCashErrorException extends ErrorException implements NotEnoughFoundsErrorException
{

}