<template>
    <Link v-if="!isActive" :href="href" class="hover:text-white text-gray-400 hover:underline w-max h-full">
    <Icon :icon="icon" class="w-full h-6"></Icon>
    </Link>
    <div v-else :href="href" class="text-white w-max h-full cursor-pointer flex">
        <Icon :icon="icon" class="w-full h-6"></Icon>
    </div>
</template>
<script>
import { Icon } from '@iconify/vue';
import { Link } from "@inertiajs/vue3"
export default {
    name: "IconNavLink",
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
            required: 'title'
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