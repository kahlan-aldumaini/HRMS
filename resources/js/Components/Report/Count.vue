<template>
    <div class="w-full p-4 bg-white rounded-md shadow-lg ">
        <div class="px-2 font-sans text-3xl font-semibold">{{ number }}</div>
        <div class="pt-2 text-lg">{{ label }}</div>
    </div>
</template>
<script>
export default {
    name: "Count",
    props: {
        number: Number,
        label: String
    }
}
</script>
