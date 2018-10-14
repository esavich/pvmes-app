<template>
    <div class="container">
        <router-link v-bind:to="{name:'home'}">Home</router-link>
        <SinglePost v-show="loaded" v-bind:post="post"></SinglePost>
        <Comments v-if="loaded" v-bind:post="post"/>
    </div>
</template>

<script>
    import SinglePost from '@/components/SinglePost.vue';
    import Comments from '@/components/Comments.vue';
    import axios from 'axios';

    export default {
        name: 'Post',
        components: {
            SinglePost,
            Comments
        },
        data() {
            return {
                post: false,
                loaded: false,
            }
        },
        created() {
            var vm = this;
            axios.get('/api/posts/' + vm.$route.params.id + '/')
                .then(function (response) {
                    vm.loaded = true;
                    vm.post = response.data.post;

                });
        }
    }
</script>
