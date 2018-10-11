<template>
    <div class="posts" v-show="loaded">
        <div class="posts__list">
            <SinglePost v-for="post in posts" v-bind:post="post" v-bind:key="post._id" v-bind:showTitleLink="true"/>
        </div>
        <Paginator v-bind:page="page" v-bind:total="totalPageCount"/>
    </div>
</template>

<script>
    import axios from 'axios'
    import SinglePost from "@/components/SinglePost.vue"
    import Paginator from "@/components/Paginator.vue"

    export default {
        name: "Posts",
        props: [
            'initPage'
        ],
        components: {
            SinglePost,
            Paginator
        },
        data() {
            return {
                posts: [],
                loaded: false,
                page: false,
                totalPageCount: false,
            }
        },
        created() {
            this.loadPosts(this.initPage);
        },
        methods: {
            loadPosts(page) {
                let vm = this;
                let url = '/api/posts/';

                vm.loaded = false;
                if (page > 1) {
                    url += '?page=' + page;
                }
                axios.get(url)
                    .then(function (response) {
                        vm.loaded = true;
                        vm.posts = response.data.posts;
                        vm.page = response.data.curPage;
                        vm.totalPageCount = response.data.totalPageCount;

                    });
            }
        },
        watch: {
            '$route'() {
                this.loadPosts(this.initPage);
            }
        }
    }
</script>

<style>

</style>