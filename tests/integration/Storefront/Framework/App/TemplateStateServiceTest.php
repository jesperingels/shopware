<?php declare(strict_types=1);

namespace Shopware\Tests\Integration\Storefront\Framework\App;

use PHPUnit\Framework\TestCase;
use Shopware\Core\Framework\App\AppCollection;
use Shopware\Core\Framework\App\Template\TemplateCollection;
use Shopware\Core\Framework\App\Template\TemplateStateService;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Test\TestCaseBase\IntegrationTestBehaviour;
use Shopware\Core\Test\AppSystemTestBehaviour;

/**
 * @internal
 */
class TemplateStateServiceTest extends TestCase
{
    use AppSystemTestBehaviour;
    use IntegrationTestBehaviour;

    /**
     * @var EntityRepository<TemplateCollection>
     */
    private EntityRepository $templateRepo;

    private TemplateStateService $templateStateService;

    /**
     * @var EntityRepository<AppCollection>
     */
    private EntityRepository $appRepo;

    protected function setUp(): void
    {
        $this->templateRepo = static::getContainer()->get('app_template.repository');
        $this->appRepo = static::getContainer()->get('app.repository');
        $this->templateStateService = static::getContainer()->get(TemplateStateService::class);
    }

    public function testActivateApp(): void
    {
        $this->loadAppsFromDir(__DIR__ . '/../../Theme/fixtures/Apps/theme', false);

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('name', 'SwagTheme'));

        $appId = $this->appRepo->searchIds($criteria, Context::createDefaultContext())->firstId();
        static::assertNotNull($appId);

        $this->templateStateService->activateAppTemplates($appId, Context::createDefaultContext());

        $activeTemplates = $this->fetchActiveTemplates($appId);
        static::assertCount(2, $activeTemplates);
    }

    public function testDeactivateApp(): void
    {
        $this->loadAppsFromDir(__DIR__ . '/../../Theme/fixtures/Apps/theme');

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('name', 'SwagTheme'));

        $appId = $this->appRepo->searchIds($criteria, Context::createDefaultContext())->firstId();
        static::assertNotNull($appId);

        $this->templateStateService->deactivateAppTemplates($appId, Context::createDefaultContext());

        $activeTemplates = $this->fetchActiveTemplates($appId);
        static::assertEmpty($activeTemplates);
    }

    private function fetchActiveTemplates(string $appId): TemplateCollection
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('appId', $appId));
        $criteria->addFilter(new EqualsFilter('active', true));

        $collection = $this->templateRepo->search($criteria, Context::createDefaultContext())->getEntities();

        static::assertInstanceOf(TemplateCollection::class, $collection);

        return $collection;
    }
}
