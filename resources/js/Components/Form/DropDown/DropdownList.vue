<template>
    <div @click="showList" class=" h-full rounded-md relative p-1" :class="classes">
        <div class="flex items-center justify-between w-full ">
            <slot name="button"></slot>
            <Icon icon="ic:round-arrow-back-ios" :rotate="show ? 1 : 3" class="text-gray-900" />
        </div>
        <div class="absolute top-full left-0 bg-white rounded-md shadow-md overflow-auto min-w-full z-50"
            :class="show ? 'max-h-52' : 'h-0'">
            <slot name="items"></slot>
        </div>
    </div>
</template>
<script>
import { Icon } from '@iconify/vue'
export default {
    name: "DropdownList",
    components: {
        Icon
    },
    props: {
        classes: {
            type: String,
            default: ""
        }
    },
    mounted() {
        window.addEventListener("click", (event) => {
            if (!this.$el.contains(event.target)) {
                this.show = false;
            }
        });
    },
    data() {
        return {
            show: false
        }
    },
    methods: {
        showList() {
            this.show = !this.show;
        }
    }
}
</script>
