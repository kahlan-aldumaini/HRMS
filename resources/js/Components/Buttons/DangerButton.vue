<template>
    <button :type="type" @click="$emit('click')" class="px-4 py-2 bg-red-500 rounded-md text-white hover:bg-red-600">
        <Loading borderColor="white" v-if="loading" />
        <slot v-else />
    </button>
</template>
<script>
import Loading from '../Form/Loading.vue';
export default {
    name: "DangerButton",
    props: {
        type: { type: String, default: "button" },
        loading: { type: Boolean, default: false },
    },
    components: { Loading }
}
</script>
