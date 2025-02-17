import template from './sw-order-create-invalid-promotion-modal.html.twig';
import './sw-order-create-invalid-promotion-modal.scss';

/**
 * @sw-package checkout
 */

const { Store } = Shopware;

// eslint-disable-next-line sw-deprecation-rules/private-feature-declarations
export default {
    template,

    compatConfig: Shopware.compatConfig,

    emits: [
        'close',
        'confirm',
    ],

    computed: {
        invalidPromotionCodes() {
            return Store.get('swOrder').invalidPromotionCodes;
        },
    },

    methods: {
        onClose() {
            this.$emit('close');
        },

        onConfirm() {
            this.$emit('confirm');
        },
    },
};
