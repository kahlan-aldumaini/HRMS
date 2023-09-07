<template>
    <div class="w-full mb-4 rounded-xl bg-white shadow-md flex items-center ">
        <div @click="!isChild ? $emit('back') : $emit('show')"
            class="h-8 w-8 cursor-pointer rounded-full  flex items-center justify-center bg-sky-600 m-3">
            <Icon v-if="isChild" icon="carbon:arrow-right"
                class="text-white hover:-rotate-45 rotate-0 transition-all duration-300 ease-linear" />
            <Icon v-else icon="carbon:arrow-right" :rotate="0.5" class="text-white -rotate-45" />
        </div>
        <p class="pr-2 font-semibold">{{ label }}</p>
    </div>
</template>
<script>
import { Icon } from '@iconify/vue';
export default {
    name: "SideCard",
    components: {
        Icon,
    },
    props: {
        label: String,
        isChild: Boolean,
    },
}
</script>
