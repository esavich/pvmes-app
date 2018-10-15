<template>
    <div class="blog-post__tags">
        tags:
        <router-link
                v-bind:to="{name: 'tagged', params: {tag: tag}}"
                v-for="tag in tags"
                class="tag badge badge-warning"
                v-bind:key="tag"
        >
            {{tag}}
        </router-link>
    </div>
</template>

<script>
    export default {
        name: "Tags",
        props: ['tags']
    }
</script>

<style>
    .tag {
        margin: 0 10px;
    }
</style>