<template>
    <div @click="select" class="w-full p-2 cursor-pointer" :class="class">
        <slot class="cursor-pointer"></slot>
    </div>
</template>

<script>
export default {
    name: "DropDownOption",
    props: {
        select: Function,
        class: String,
    }
}
</script>