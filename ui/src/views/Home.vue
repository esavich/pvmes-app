<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <Posts v-bind:initPage="page"/>

            </div>
            <div class="col-md-4">
                sidebar
            </div>
        </div>
    </div>
</template>

<script>
    // @ is an alias to /src
    // import HelloWorld from '@/components/HelloWorld.vue';
    import Posts from '@/components/Posts.vue';

    export default {
        name: 'home',
        components: {
            Posts
        },
        computed: {
            page() {
                return parseInt(this.$route.params.page) || 1;
            }
        }
    }
</script>
