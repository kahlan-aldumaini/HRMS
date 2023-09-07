<template>
  <button
    :disabled="loading"
    :type="type"
    class="px-4 py-2 bg-gray-200 rounded-md text-gray-500 hover:bg-gray-300"
  >
    <Loading v-if="loading" />
    <slot v-else />
  </button>
</template>
<script>
import Loading from "../Form/Loading.vue";
export default {
  name: "SecondaryButton",
  props: {
    type: { type: String, default: "button" },
    loading: { type: Boolean, default: false },
  },
  components: { Loading },
};
</script>
