<template>
    <label class="w-full">
        <span class="text-sm block font-semibold mb-1 mr-4">اسم المستخدم</span>
        <div class="flex rounded-full bg-indigo-200  items-center px-4">
            <Icon icon="carbon:user" class="text-indigo-900" />
            <input type="text" v-model="form.user_name" class="focus:ring-0 border-0 pr-1 text-sm bg-transparent" />
        </div>
        <small v-if="form.errors.user_name != null" class="text-red-800 text-xs mt-1 mr-4 font-semibold"
            v-html="form.errors.user_name"></small>
    </label>
</template>
<script>
export default {
    name: "LoginInput",
    props: {
        label: {
            type: String,
            default: '',
        },
        icon: {
            type: String,
            default: '',
        }
    }
}
</script>