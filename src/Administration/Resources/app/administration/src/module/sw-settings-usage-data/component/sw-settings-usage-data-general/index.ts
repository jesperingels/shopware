import template from './sw-settings-usage-data-general.html.twig';

/**
 * @sw-package data-services
 *
 * @private
 */
export default Shopware.Component.wrapComponentConfig({
    name: 'sw-settings-usage-data-general',

    compatConfig: Shopware.compatConfig,

    template,

    inject: [
        'usageDataService',
    ],

    methods: {
        async createdComponent() {
            const consent = await this.usageDataService.getConsent();

            Shopware.Store.get('usageData').updateConsent(consent);
        },
    },

    created() {
        void this.createdComponent();
    },
});
