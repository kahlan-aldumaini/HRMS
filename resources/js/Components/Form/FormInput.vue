<template>
    <label class="w-full block mb-4 px-2">
        <span class="text-sm block font-semibold mb-1 mr-4" v-html="label"></span>
        <div class="flex rounded-md bg-white border-2 border-gray-500 items-center">
            <input :min="min" :max="max" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
                dir="rtl" :type="type" ref="input" class="focus:ring-0 border-0 pr-1 text-sm bg-transparent" />
        </div>
        <small v-if="error != null" class="text-red-800 text-xs mt-1 mr-4 font-semibold" v-html="error"></small>
    </label>
</template>
<script>
export default {
    props: {
        label: String,
        modelValue: String,
        type: String,
        error: String,
        min: {},
        max: {},
    },
    deta() {
        return {
            value: this.modelValue
        }
    }
}
</script>
