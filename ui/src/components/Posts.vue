<template>
    <div class="posts" v-show="loaded">
        <div class="posts__list">
            <SinglePost v-for="post in posts" v-bind:post="post" v-bind:key="post._id" v-bind:showTitleLink="true"/>
        </div>
        <Paginator v-bind:page="page" v-bind:total="totalPageCount" v-bind:perPage="postPerPage"/>
    </div>
</template>

<script>
    import axios from 'axios'
    import SinglePost from "@/components/SinglePost.vue"
    import Paginator from "@/components/Paginator.vue"

    export default {
        name: "Posts",
        props: [
            'initPage',
            'perPage'
        ],
        components: {
            SinglePost,
            Paginator
        },
        data() {
            return {
                posts: [],
                loaded: false,
                postPerPage: this.perPage || 10,
                totalPosts: false
            }
        },
        created() {
            this.loadPosts(this.offset, this.postPerPage);
        },
        computed: {
            offset() {
                return this.postPerPage * (this.initPage - 1);
            },
            page() {
                return this.offset / this.postPerPage + 1;
            },
            totalPageCount() {
                return Math.ceil(this.totalPosts / this.postPerPage);
            }
        },
        methods: {
            loadPosts(offset, limit) {
                let vm = this;
                let url = '/api/posts/?limit=' + limit + '&skip=' + offset;

                vm.loaded = false;

                axios.get(url)
                    .then(function (response) {
                        vm.loaded = true;
                        vm.posts = response.data.posts;
                        vm.totalPosts = response.data.totalPosts;

                    });
            }
        },
        watch: {
            '$route'() {
                this.loadPosts(this.offset, this.postPerPage);
            }
        }
    }
</script>

<style>

</style>