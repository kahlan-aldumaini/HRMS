<template>
  <Model :show="showModel" :hide="hide">
    <template #title>
      <slot name="header"></slot>
    </template>
    <div class="w-96">
      <div v-if="existsInOnly(keys.day)">
        <FormDropDown
          label="اليوم"
          :modelValue="form.day"
          :error="form.errors.day"
          selectKey="name"
          :selectData="days"
          :selectFun="(e) => (form.day = e)"
        />
      </div>
      <div v-if="existsInOnly(keys.bransh)">
        <FormDropDown
          label="الفرع"
          :modelValue="form.bransh"
          :error="form.errors.bransh"
          :selectData="branshes"
          :selectFun="(e) => (form.bransh = e)"
        />
      </div>
      <div v-if="existsInOnly(keys.group)">
        <FormDropDown
          label="المجموعة"
          :modelValue="form.group"
          :error="form.errors.group"
          :selectData="groups"
          :selectFun="(e) => (form.group = e)"
        />
      </div>
      <div class="w-full grid grid-cols-2 gap-2">
        <div v-if="existsInOnly(keys.from_date)">
          <label class="block w-full px-2 mb-4">
            <span class="block mb-1 mr-4 text-sm font-semibold">من تاريخ</span>
            <div
              class="flex items-center bg-white border-2 border-gray-500 rounded-md"
            >
              <input
                dir="rtl"
                type="date"
                v-model="form.from_date"
                class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
              />
            </div>
            <small
              v-show="form.errors.from_date"
              class="mt-1 mr-4 text-xs font-semibold text-red-800"
              v-html="form.errors.from_date"
            ></small>
          </label>
        </div>
        <div v-if="existsInOnly(keys.to_date)">
          <label class="block w-full px-2 mb-4">
            <span class="block mb-1 mr-4 text-sm font-semibold">الى تاريخ</span>
            <div
              class="flex items-center bg-white border-2 border-gray-500 rounded-md"
            >
              <input
                dir="rtl"
                type="date"
                v-model="form.to_date"
                class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
              />
            </div>
            <small
              v-show="form.errors.to_date"
              class="mt-1 mr-4 text-xs font-semibold text-red-800"
              v-html="form.errors.to_date"
            ></small>
          </label>
        </div>
      </div>
    </div>
    <template #footer>
      <div class="w-full grid grid-cols-2 gap-2">
        <SecondaryButton :loading="form.processing" @click="submit">
          فلتر
        </SecondaryButton>
        <DangerButton @click="hide"> الغاء </DangerButton>
      </div>
    </template>
  </Model>
</template>
<script>
import axios from "axios";
import Model from "@/Components/Models/Model.vue";
import { useForm } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/Buttons/SecondaryButton.vue";
import DangerButton from "@/Components/Buttons/DangerButton.vue";
import FormDropDown from "@/Components/Form/DropDown/FormDropDown.vue";

export default {
  name: "Filter",
  props: {
    employees: { type: Array, default: null },
    show: Boolean,
    hide: Function,
    url: String,
    success: Function,
    only: Array,
    method: { typ: String, default: "get" },
    filter: { type: Object, default: null },
  },
  data() {
    return {
      days: [
        {
          id: 1,
          name: "السبت",
        },
        {
          id: 2,
          name: "الاحد",
        },
        {
          id: 3,
          name: "الاثنين",
        },
        {
          id: 4,
          name: "الثلاثاء",
        },
        {
          id: 5,
          name: "الأربعاء",
        },
        {
          id: 6,
          name: "الخميس",
        },
        {
          id: 7,
          name: "الجمعه",
        },
      ],
      groups: [],
      employeesData: [],
      branshes: [],
      showModel: false,
      form: useForm({
        day: null,
        group: null,
        from_date: null,
        to_date: null,
        bransh: null,
        type: "filter",
      }),
      keys: {
        group: "group",
        day: "day",
        from_date: "from_date",
        to_date: "to_date",
        bransh: "bransh",
      },
    };
  },
  created() {
    if (!this.employees) {
      this.getEmployees();
    }
    this.getGroups();
    this.getBranshes();
    if (this.filter) {
      this.filter["type"] = "filter";
      this.form = useForm(this.filter);
    }
  },
  watch: {
    show(v) {
      this.showModel = v;
    },
  },
  methods: {
    getEmployees() {
      axios.get("/get-employees").then((res) => {
        this.employeesData = res.data;
      });
    },
    getGroups() {
      axios.get("/get-groups").then((res) => {
        this.groups = res.data;
      });
    },
    getBranshes() {
      axios.get("/get_bransh").then((res) => {
        this.branshes = res.data;
      });
    },
    submit() {
      this.form[this.method](this.url, {
        onSuccess: () => {
          this.success();
        },
      });
    },
    existsInOnly(key) {
      return this.only.some((v) => v == key);
    },
  },
  components: { Model, SecondaryButton, DangerButton, FormDropDown },
};
</script>
