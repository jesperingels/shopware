<?php declare(strict_types=1);

namespace Shopware\Core\Content\Product\DataAbstractionLayer;

use Shopware\Core\Content\Product\Exception\DuplicateProductNumberException;
use Shopware\Core\Framework\DataAbstractionLayer\Dbal\ExceptionHandlerInterface;
use Shopware\Core\Framework\Log\Package;

#[Package('framework')]
class ProductExceptionHandler implements ExceptionHandlerInterface
{
    public function getPriority(): int
    {
        return ExceptionHandlerInterface::PRIORITY_DEFAULT;
    }

    public function matchException(\Throwable $e): ?\Throwable
    {
        if (preg_match('/SQLSTATE\[23000\]:.*1062 Duplicate.*uniq.product.product_number__version_id\'/', $e->getMessage())) {
            $number = [];
            preg_match('/Duplicate entry \'(.*)\' for key/', $e->getMessage(), $number);
            $numberMatch = $number[1] ?? '';
            $position = (int) strrpos($numberMatch, '-');
            $number = substr($numberMatch, 0, $position);

            return new DuplicateProductNumberException($number, $e);
        }

        return null;
    }
}
