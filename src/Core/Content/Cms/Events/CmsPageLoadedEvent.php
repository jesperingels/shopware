<?php declare(strict_types=1);

namespace Shopware\Core\Content\Cms\Events;

use Shopware\Core\Content\Cms\CmsPageCollection;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;
use Shopware\Core\Framework\Event\NestedEvent;
use Shopware\Core\Framework\Event\ShopwareSalesChannelEvent;
use Shopware\Core\Framework\Log\Package;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

#[Package('discovery')]
class CmsPageLoadedEvent extends NestedEvent implements ShopwareSalesChannelEvent
{
    /**
     * @var Request
     *
     * @deprecated tag:v6.7.0 - Will be natively typed
     */
    protected $request;

    /**
     * @var CmsPageCollection
     *
     * @deprecated tag:v6.7.0 - Will be natively typed
     */
    protected $result;

    /**
     * @var SalesChannelContext
     *
     * @deprecated tag:v6.7.0 - Will be natively typed
     */
    protected $salesChannelContext;

    /**
     * @param CmsPageCollection $result
     */
    public function __construct(
        Request $request,
        EntityCollection $result,
        SalesChannelContext $salesChannelContext
    ) {
        $this->request = $request;
        $this->result = $result;
        $this->salesChannelContext = $salesChannelContext;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return CmsPageCollection
     */
    public function getResult(): EntityCollection
    {
        return $this->result;
    }

    public function getContext(): Context
    {
        return $this->salesChannelContext->getContext();
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }
}
