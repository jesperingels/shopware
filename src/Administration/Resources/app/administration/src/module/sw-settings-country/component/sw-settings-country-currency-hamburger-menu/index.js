/**
 * @sw-package fundamentals@discovery
 */
import template from './sw-settings-country-currency-hamburger-menu.html.twig';
import './sw-settings-country-currency-hamburger-menu.scss';

// eslint-disable-next-line sw-deprecation-rules/private-feature-declarations
export default {
    template,

    compatConfig: Shopware.compatConfig,

    inject: ['acl'],

    emits: ['currency-change'],

    props: {
        isLoading: {
            type: Boolean,
            required: false,
            default: false,
        },
        options: {
            type: Array,
            required: true,
        },
    },

    methods: {
        onCheckCurrency(currencyId, isChecked) {
            this.$emit('currency-change', currencyId, isChecked);
        },
    },
};
