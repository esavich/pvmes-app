<template>
    <div>
        <div class="row justify-content-between">
            <h3 class="col-auto">Comments <span class="badge badge-light" v-if="count">{{count}}</span></h3>
            <CommentSorter v-bind:order="sort" class="qwe col-auto" v-on:order="sortComments($event)" v-if="count > 1"/>
        </div>
        <CommentsList v-if="loaded" v-bind:comments="comments"/>
        <CommentForm v-bind:post="post" v-on:added="loadComments(post._id)"/>
    </div>
</template>

<script>
    import axios from 'axios';
    import CommentsList from '@/components/CommentsList.vue';
    import CommentForm from '@/components/CommentForm.vue';
    import CommentSorter from '@/components/CommentSorter.vue';

    export default {
        name: "Comments",
        components: {
            CommentForm,
            CommentsList,
            CommentSorter
        },
        data() {
            return {
                comments: [],
                loaded: false,
                sort: -1
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
            },
            sortComments(order) {
                this.comments.sort((a, b) => (a.date > b.date) ? order : ((b.date > a.date) ? -order : 0))
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