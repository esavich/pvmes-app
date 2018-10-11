<template>
  <div id="app">
    <div class="container">
      <header>
        <h1>
          <router-link to="/">PVMES</router-link>
        </h1>
      </header>
    </div>
    <!--<div id="nav">-->
    <!--<router-link to="/">Home</router-link> |-->
    <!--<router-link to="/about">About</router-link>-->
    <!--</div>-->
    <router-view/>
  </div>
</template>

<style lang="scss">
  @import "~bootstrap/scss/bootstrap";

</style>
