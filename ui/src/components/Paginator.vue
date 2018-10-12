<template>
    <nav>
        <ul class="pagination  justify-content-center">
            <li class="page-item" v-bind:class="{disabled : page === 1}">
                <router-link class="page-link page-link--edge" v-bind:to="prev">Previous</router-link>
            </li>
            <li v-for="n in total " class="page-item" v-bind:key="n" v-bind:class="{ active : page === n}">
                <router-link class="page-link" v-bind:to="getLink(n)">{{n}}</router-link>
            </li>
            <li class="page-item" v-bind:class="{disabled : page === total}">
                <router-link class="page-link page-link--edge" v-bind:to="next">Next</router-link>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: "Paginator",
        props: ['page', 'total', 'perPage'],
        computed: {
            pagingLevel() {

                return this.$route.name.replace('Paged', '');
            },
            prev() {
                if (this.page === 2) {
                    return {name: this.pagingLevel}
                }

                return {name: this.pagingLevel + 'Paged', params: {page: this.page - 1}}
            },
            next() {
                return {name: this.pagingLevel + 'Paged', params: {page: this.page + 1}}
            }
        },
        methods: {
            getLink(n) {
                return n === 1 ? {name: this.pagingLevel} : {name: this.pagingLevel + 'Paged', params: {page: n}}
            }
        }
    }
</script>

<style lang="scss">
    .page-link--edge {
        min-width: 100px;
        text-align: center;
    }
</style>