<template>
    <Link :href="href" v-if="!isActive"
        class="flex w-40 border-r-2 hover:border-white border-primary  hover:underline no-underline truncate hover:text-white text-gray-400 my-2 mx-auto items-center">
    <Icon :icon="icon" class="px-4 w-14 h-6" />
    <p v-html="title"></p>
    </Link>
    <div v-else class="text-white w-40 truncate my-2 cursor-pointer flex border-r-2 border-white mx-auto">
        <Icon :icon="icon" class="px-4 w-14 h-6" />
        <p v-html="title"></p>
    </div>
</template>
<script>

import { Icon } from '@iconify/vue';
import { Link } from "@inertiajs/vue3"
export default {
    name: "NavLink",
    components: {
        Icon,
        Link
    },
    props: {
        icon: {
            type: String,
            required: true
        },
        href: {
            type: String,
            required: true
        },
        title: {
            type: String,
            required: true
        },
    },
    computed: {
        isActive() {
            return this.$page.url === this.href;
        }
    },
    methods: {
        navigate(event) {
            event.preventDefault();
            this.$inertia.visit(this.href);
        }
    }
}

</script>