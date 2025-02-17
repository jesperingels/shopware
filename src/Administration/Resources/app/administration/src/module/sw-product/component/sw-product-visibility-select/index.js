/*
 * @sw-package inventory
 */

import template from './sw-product-visibility-select.html.twig';

const { EntityCollection, Criteria } = Shopware.Data;

// eslint-disable-next-line sw-deprecation-rules/private-feature-declarations
export default {
    template,

    emits: ['item-add'],

    props: {
        criteria: {
            type: Object,
            required: false,
            default(props) {
                const criteria = new Criteria(1, props.resultLimit);
                criteria.addSorting(Criteria.sort('name', 'ASC'));
                return criteria;
            },
        },
    },

    data() {
        return {
            defaultVisibility: 30,
        };
    },

    computed: {
        product() {
            return Shopware.Store.get('swProductDetail').product;
        },

        repository() {
            return this.repositoryFactory.create('sales_channel');
        },

        associationRepository() {
            return this.repositoryFactory.create('product_visibility');
        },
    },

    methods: {
        isSelected(item) {
            return this.currentCollection.some((entity) => {
                return entity.salesChannelId === item.id;
            });
        },

        addItem(item) {
            // Remove when already selected
            if (this.isSelected(item)) {
                const associationEntity = this.currentCollection.find((entity) => {
                    return entity.salesChannelId === item.id;
                });
                this.remove(associationEntity);

                return;
            }

            // Create new entity
            const newSalesChannelAssociation = this.associationRepository.create(this.entityCollection.context);
            newSalesChannelAssociation.productId = this.product.id;
            newSalesChannelAssociation.productVersionId = this.product.versionId;
            newSalesChannelAssociation.salesChannelId = item.id;
            newSalesChannelAssociation.visibility = this.defaultVisibility;
            newSalesChannelAssociation.salesChannel = item;

            this.$emit('item-add', item);

            const changedCollection = EntityCollection.fromCollection(this.currentCollection);
            changedCollection.add(newSalesChannelAssociation);

            this.emitChanges(changedCollection);
            this.onSelectExpanded();
        },
    },
};
