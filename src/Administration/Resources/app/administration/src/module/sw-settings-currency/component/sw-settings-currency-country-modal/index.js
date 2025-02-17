/**
 * @sw-package fundamentals@framework
 */
import template from './sw-settings-currency-country-modal.html.twig';

const { Mixin } = Shopware;
const { Criteria } = Shopware.Data;
const { mapPropertyErrors } = Shopware.Component.getComponentHelper();

// eslint-disable-next-line sw-deprecation-rules/private-feature-declarations
export default {
    template,

    compatConfig: Shopware.compatConfig,

    inject: ['repositoryFactory'],

    emits: [
        'edit-cancel',
        'save',
    ],

    mixins: [
        Mixin.getByName('notification'),
    ],

    props: {
        currencyCountryRounding: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            assignedCountryIds: [],
        };
    },

    computed: {
        countryCriteria() {
            const criteria = new Criteria(1, 25);
            criteria.addSorting(Criteria.sort('name', 'ASC'));
            return criteria;
        },

        countryRepository() {
            return this.repositoryFactory.create('country');
        },

        assignedCountriesCriteria() {
            const criteria = new Criteria(1, 500);
            criteria.addAssociation('currencyCountryRoundings');
            criteria.addFilter(
                Criteria.equals('currencyCountryRoundings.currencyId', this.currencyCountryRounding.currencyId),
            );

            return criteria;
        },

        ...mapPropertyErrors('currencyCountryRounding', ['countryId']),
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.countryRepository.searchIds(this.assignedCountriesCriteria, Shopware.Context.api).then((res) => {
                this.assignedCountryIds = res.data;
            });
        },

        onCancel() {
            this.$emit('edit-cancel');
        },

        onSave() {
            this.$emit('save');
        },

        shouldDisableCountry(country) {
            // Do not disable if the country is already selected for this currency country rounding
            if (this.currencyCountryRounding.countryId === country.id) {
                return false;
            }

            return this.assignedCountryIds.includes(country.id);
        },
    },
};
