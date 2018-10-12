<template>
    <div class="sidebar">
        <h2>Top posts</h2>
        <TopPosts count="10"/>
        <h2>Tags</h2>
        <Taglist/>
    </div>
</template>

<script>
    import TopPosts from '@/components/TopPosts.vue';
    import Taglist from '@/components/Taglist.vue';

    export default {
        name: "Sidebar",
        components: {
            TopPosts,
            Taglist
        }
    }
</script>

<style>

</style>