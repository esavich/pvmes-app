<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <Posts v-bind:initPage="page" v-bind:perPage="20"/>

            </div>
            <div class="col-md-4">
                <Sidebar/>
            </div>
        </div>
    </div>
</template>

<script>
    // @ is an alias to /src
    // import HelloWorld from '@/components/HelloWorld.vue';
    import Posts from '@/components/Posts.vue';
    import Sidebar from '@/components/Sidebar.vue';

    export default {
        name: 'home',
        components: {
            Posts,
            Sidebar
        },
        computed: {
            page() {
                return parseInt(this.$route.params.page) || 1;
            }
        }
    }
</script>
