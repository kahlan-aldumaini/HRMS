<template>
    <label class="block w-full mb-4">
        <span class="block mb-1 mr-4 text-sm font-semibold" v-html="label"></span>
        <div class="px-2 border rounded-md">
            <DropdownList classes="bg-white border-2 border-gray-500">
                <template #button>
                    <div class="px-1 ">{{ selectData?.find(v => v[selectKey] == modelValue)?.[showSelectKey] }}</div>
                </template>
                <template #items>
                    <DropDownOption class="hover:bg-blue-500" v-for="item in           selectData          "
                        :select="e => localSelectFun(item[selectKey])">
                        {{ item[showSelectKey] }}
                    </DropDownOption>
                </template>
            </DropdownList>
        </div>
        <small v-if="error != null" class="mt-1 mr-4 text-xs font-semibold text-red-800" v-html="error"></small>
    </label>
</template>
<script>
import DropDownOption from './DropDownOption.vue';
import DropdownList from './DropdownList.vue';

export default {
    name: "FormDropDown",
    props: {
        label: String,
        modelValue: String,
        error: String,
        showSelectKey: { type: String, default: 'name' },
        selectKey: { type: String, default: 'id' },
        selectData: Array,
        selectFun: Function,
    },
    deta() {
        return {
            value: this.modelValue
        };
    },
    components: { DropdownList, DropDownOption },
    methods: {
        localSelectFun(item) {
            this.$emit('update:modelValue', item)
            this.selectFun(item)
        }
    }
}
</script>
