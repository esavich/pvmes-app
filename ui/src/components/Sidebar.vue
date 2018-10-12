<template>
    <div class="sidebar">
        <h2>Top posts</h2>
        <TopPosts count="10"/>
        <h2>Tags</h2>
    </div>
</template>

<script>
    import TopPosts from '@/components/TopPosts.vue';

    export default {
        name: "Sidebar",
        components: {
            TopPosts
        }
    }
</script>

<style>

</style>