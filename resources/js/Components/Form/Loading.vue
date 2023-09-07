<template>
    <div class="w-full h-full flex items-center justify-center">
        <div
            :class="`h-${size} w-${size} border-${borderSize} border-${borderColor} border-r-transparent rounded-full animate-spin`">
        </div>
    </div>
</template>

<script >
export default {
    props: {
        borderColor: { type: String, default: 'primary' },
        size: { type: String, default: '4' },
        borderSize: { type: String, default: '2' },
    }
}
</script>

