<template>
    <div class="blog-post__tags">
        tags: <span v-for="tag in tags" class="tag badge badge-warning" v-bind:key="tag">{{tag}}</span>
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
        display: inline-block;
        margin: 0 10px;
    }
</style>