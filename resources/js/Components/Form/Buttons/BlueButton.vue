<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit'
    }
})
</script>
<template>
    <button :type="type" class="w-full bg-blue-500 text-white py-2 text-sm font-semibold rounded-full">
        <slot />
    </button>
</template>