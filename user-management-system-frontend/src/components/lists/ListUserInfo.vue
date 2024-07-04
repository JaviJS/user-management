<template>
  <v-list :class="type === 'light' ? 'list_light' : 'list_dark'">
    <v-list-item
      :prepend-avatar="props.img"
      :subtitle="props.subtitle"
      :title="props.title"
    >
    </v-list-item>
  </v-list>
</template>
<script setup>
const props = defineProps(["title", "subtitle", "img", "type"]);
</script>
<style scoped lang="scss">
.list_light {
  background-color: rgb(24, 103, 192);
  color: white;
}

</style>
