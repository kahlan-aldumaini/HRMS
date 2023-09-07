<template>
  <Model :show="showModel" :hide="hide">
    <template #title>
      {{ title }}
    </template>

    <div v-if="items" class="grid grid-cols-2 gap-2 px-2">
      <div v-for="(item, key) in items" :key="item" class="flex items-center">
        <span
          class="p-1 px-2 ml-1 font-semibold text-gray-800 bg-gray-100 rounded-md"
          >{{ key }}:
        </span>

        <span class="p-1">{{ item }}</span>
      </div>
    </div>
    <loading v-else />
  </Model>
</template>
<script>
import Loading from "../Form/Loading.vue";
import Model from "./Model.vue";
export default {
  name: "Name",
  props: {
    show: Boolean,
    hide: Function,
    items: Array,
    title: String,
  },
  data() {
    return {
      showModel: false,
    };
  },
  watch: {
    show(v) {
      this.showModel = v;
    },
  },
  components: { Model, Loading },
  methods: {
    getType(item) {
      return typeof item;
    },
  },
};
</script>
