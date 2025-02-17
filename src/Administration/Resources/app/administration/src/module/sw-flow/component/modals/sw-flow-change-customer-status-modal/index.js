import template from './sw-flow-change-customer-status-modal.html.twig';

const { Component, Store } = Shopware;
const { mapState } = Component.getComponentHelper();

/**
 * @private
 * @sw-package after-sales
 */
export default {
    template,

    compatConfig: Shopware.compatConfig,

    inject: ['repositoryFactory'],

    emits: [
        'modal-close',
        'process-finish',
    ],

    props: {
        sequence: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            active: true,
            fieldError: null,
        };
    },

    computed: {
        ...mapState(() => Store.get('swFlow'), ['customerStatus']),

        options() {
            return [
                {
                    value: true,
                    label: this.$tc('sw-flow.modals.customerStatus.active'),
                },
                {
                    value: false,
                    label: this.$tc('sw-flow.modals.customerStatus.inactive'),
                },
            ];
        },
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            if (this.sequence?.config) {
                this.active = this.sequence?.config.active;
                return;
            }
            this.active = true;
        },

        onClose() {
            this.$emit('modal-close');
        },

        onAddAction() {
            this.sequence.config = { active: this.active };

            this.$emit('process-finish', this.sequence);
        },
    },
};
