<template>
    <div>
        <h3>Comments</h3>
        <CommentsList v-if="loaded" v-bind:comments="comments"/>
        <CommentForm v-bind:post="post" v-on:added="loadComments(post._id)"/>
    </div>
</template>

<script>
    import axios from 'axios';
    import CommentsList from '@/components/CommentsList.vue';
    import CommentForm from '@/components/CommentForm.vue';

    export default {
        name: "Comments",
        components: {
            CommentForm,
            CommentsList
        },
        data() {
            return {
                comments: [],
                loaded: false
            }
        },
        props: [
            'post'
        ],
        created() {
            this.loadComments(this.post._id);
        },
        computed: {
            count() {
                return this.comments.length;
            }
        },
        methods: {
            loadComments(id) {
                let vm = this;
                let url = '/api/comments/?postId=' + id;
                vm.loaded = false;

                axios.get(url)
                    .then(function (response) {
                        vm.loaded = true;
                        vm.comments = response.data.comments;
                    });
            }
        },
    }
</script>

<style lang="scss">
    .comments__item {
        margin-bottom: 20px;
    }

    .comment {
        border-bottom: 1px solid #ccc;
        padding: 10px;
    }
</style>