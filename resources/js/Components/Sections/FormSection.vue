<template>
    <div class="w-full h-max px-2 py-4">
        <slot name="header">
            <div class="w-full flex items-center justify-between max-h-20">
                <p class="pl-2 text-2xl text-slate-700" v-html="label">
                </p>
                <div class="w-3/4 h-full flex items-center">
                    <div class="w-full h-1 rounded-full bg-slate-500"></div>
                </div>
            </div>
        </slot>
        <div class="w-full pt-4 px-2">
            <slot />
        </div>
        <div class="w-full pt-4 px-2">
            <slot name="footer" />
        </div>
    </div>
</template>
<script>
export default {
    name: 'FormSection',
    props: {
        label: String,

    }
}
</script>
