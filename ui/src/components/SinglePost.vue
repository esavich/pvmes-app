<template>
    <div class="blog-post">
        <h2 class="blog-post__title">
            <router-link v-bind:to="{name:'post', params: {id: post._id}}" v-if="showLink">{{post.title}}</router-link>
            <template v-else>{{post.title}}</template>
        </h2>
        <p class="blog-post__meta">{{ new Date(post.date).toLocaleString("ru")}} by <span class="text-info">{{post.author }}</span>
        </p>

        <div class="blog-post__body">
            {{post.text}}
        </div>
        <hr>
        <Tags v-bind:tags="post.tags"/>
    </div>
</template>

<script>
    import Tags from "@/components/Tags.vue"

    export default {
        name: "SinglePost",
        props: [
            'post',
            'showTitleLink'
        ],
        components: {
            Tags
        },
        data() {
            return {
                showLink: this.showTitleLink || false
            }
        }
    }
</script>

<style lang="scss">
    .blog-post {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
        &__title a {
            color: #ccc;
            text-decoration: underline;
            &:hover {
                text-decoration: none;
            }
        }
    }
</style>