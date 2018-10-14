<template>
    <div class="btn-group">
        <button
                type="button"
                class="btn btn-sm "
                v-bind:class="[sortOrder === -1 ? 'btn-primary' : 'btn-outline-primary']"
                v-on:click="setSort(-1)"
        >
            New first
        </button>
        <button
                type="button"
                class="btn btn-sm"
                v-bind:class="[sortOrder === 1 ? 'btn-primary' : 'btn-outline-primary']"
                v-on:click="setSort(1)"

        >
            Old first
        </button>
    </div>
</template>

<script>
    export default {
        name: "CommentSorter",
        props: ['order'],
        data() {
            return {
                sortOrder: this.order
            }
        },
        methods: {
            setSort(sort) {
                this.sortOrder = sort;
                this.$emit('order', this.sortOrder);
            }
        }
    }
</script>

<style>

</style>