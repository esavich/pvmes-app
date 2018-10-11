<template>
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item" v-bind:class="{disabled : page === 1}">
                <router-link class="page-link" v-bind:to="prev">Previous</router-link>
            </li>
            <li class="page-item" v-bind:class="{disabled : page === total}">
                <router-link class="page-link" v-bind:to="next">Next</router-link>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: "Paginator",
        props: ['page', 'total'],
        computed: {
            prev() {
                if (this.page === 2) {
                    return {name: 'home'}
                }

                return {name: 'homePaged', params: {page: this.page - 1}}
            },
            next() {
                return {name: 'homePaged', params: {page: this.page + 1}}
            }
        }
    }
</script>

<style lang="scss">
    .page-link {
        min-width: 100px;
        text-align: center;
    }
</style>