<template>
    <ul class="top-posts">
        <li v-for="post in posts" v-bind:key="post._id">
            <router-link v-bind:to="{name:'post', params: {id: post._id}}">{{post.title}}</router-link>
            ({{post.rating}})
        </li>
    </ul>
</template>

<script>
    import axios from 'axios'

    export default {
        name: "TopPosts",
        props: ['count'],
        data() {
            return {
                posts: []
            }
        },
        created() {
            this.loadPosts(this.count);
        },
        methods: {
            loadPosts(limit) {
                let vm = this;
                let url = '/api/posts/?limit=' + limit + '&orderBy=rating&order=desc';

                vm.loaded = false;

                axios.get(url)
                    .then(function (response) {
                        vm.loaded = true;
                        vm.posts = response.data.posts;
                        vm.totalPosts = response.data.totalPosts;

                    });
            }
        }
    };

</script>

<style>

</style>