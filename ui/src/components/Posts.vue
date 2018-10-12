<template>
    <div class="posts" v-show="loaded">
        <h2 v-show="tag">Posts with tag: {{tag}}</h2>
        <div class="posts__list">
            <SinglePost v-for="post in posts" v-bind:post="post" v-bind:key="post._id" v-bind:showTitleLink="true"/>
        </div>
        <Paginator v-if="totalPageCount > 1" v-bind:page="page" v-bind:total="totalPageCount"
                   v-bind:perPage="postPerPage"/>
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
            'perPage',
            'tag'
        ],
        components: {
            SinglePost,
            Paginator
        },
        data() {
            return {
                posts: [],
                loaded: false,

                totalPosts: false
            }
        },
        created() {
            this.loadPosts(this.offset, this.postPerPage, this.tag);
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
            },
            postPerPage() {
                return this.perPage || 10;
            }
        },
        methods: {
            loadPosts(offset, limit, tag) {
                let vm = this;
                let url = '/api/posts/?limit=' + limit + '&skip=' + offset;
                if (tag) {
                    url += '&tag=' + tag;
                }
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
                this.loadPosts(this.offset, this.postPerPage, this.tag);
            }
        }
    }
</script>

<style>

</style>