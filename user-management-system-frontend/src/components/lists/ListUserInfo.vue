<template>
  <v-list>
    <v-list-item
      :prepend-avatar="props.img"
      :subtitle="props.subtitle"
      :title="props.title"
    >
    </v-list-item>
  </v-list>
</template>
<script setup>
const props = defineProps(["title", "subtitle", "img"]);
</script>
<style scoped lang="scss"></style>
