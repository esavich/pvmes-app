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
        <div class="blog-post__rating">Rating: {{post.rating}}</div>
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
    @import "../assets/colors";
    @import "../assets/mixins";
    .blog-post {
        border: 1px solid $light-gray;
        padding: 10px;
        margin-bottom: 10px;
        &__title a {
            @include underlined;
        }
        &__rating {
            margin-top: 10px;
            font-size: 12px;
            color: $light-gray;
        }
    }
</style>