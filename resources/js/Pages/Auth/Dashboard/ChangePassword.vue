<template>
  <div class="w-screen h-screen flex items-center justify-center bg-gray-200">
    <form
      @submit.prevent="submit"
      method="post"
      class="bg-white rounded-xl shadow-xl shadow-indigo-200 min-w-52 min-h-max px-6 py-4"
    >
      <div class="w-full py-2 text-center font-bold border-b-2 mb-4">
        <h1 class="text-xl">تغيير كلمة المرور</h1>
      </div>
      <label class="w-full block mb-6">
        <span class="text-sm block font-semibold mb-1 mr-4">كلمة المرور</span>
        <div class="flex rounded-full bg-blue-200 items-center px-4">
          <Icon icon="material-symbols:key-outline" class="text-indigo-900" />
          <input
            :type="!showPassword ? 'password' : 'text'"
            v-model="form.password"
            class="focus:ring-0 border-0 pr-1 text-sm bg-transparent"
          />

          <Icon
            v-if="showPassword"
            @click="showPassword = !showPassword"
            icon="iconamoon:eye"
            class="text-indigo-900 cursor-pointer"
          />
          <Icon
            v-else
            @click="showPassword = !showPassword"
            icon="iconamoon:eye-off"
            class="text-indigo-900 cursor-pointer"
          />
        </div>
        <small
          v-if="form.errors.password != null"
          class="text-red-800 text-xs mt-1 mr-4 font-semibold"
          v-html="form.errors.password"
        ></small>
      </label>
      <label class="w-full block mb-6">
        <span class="text-sm block font-semibold mb-1 mr-4"
          >تأكيد كلمة المرور</span
        >
        <div class="flex rounded-full bg-blue-200 items-center px-4">
          <Icon icon="material-symbols:key-outline" class="text-indigo-900" />
          <input
            :type="!showPassword ? 'password' : 'text'"
            v-model="form.password_confirmation"
            class="focus:ring-0 border-0 pr-1 text-sm bg-transparent"
          />

          <Icon
            v-if="showPassword"
            @click="showPassword = !showPassword"
            icon="iconamoon:eye"
            class="text-indigo-900 cursor-pointer"
          />
          <Icon
            v-else
            @click="showPassword = !showPassword"
            icon="iconamoon:eye-off"
            class="text-indigo-900 cursor-pointer"
          />
        </div>
        <small
          v-if="form.errors.password_confirmation != null"
          class="text-red-800 text-xs mt-1 mr-4 font-semibold"
          v-html="form.errors.password_confirmation"
        ></small>
      </label>
      <BlueButton> تغيير كلمة المرور </BlueButton>
    </form>
  </div>
</template>
<script>
import { useForm } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import BlueButton from "@/Components/Form/Buttons/BlueButton.vue";

export default {
  name: "Login",
  components: {
    Icon,
    BlueButton,
  },
  data: () => ({
    form: useForm({
      password_confirmation: "",
      password: "",
    }),
    showPassword: false,
    showPasswordConfirm: false,
  }),
  methods: {
    submit() {
      this.form.post("/chage-password", {
        onSuccess: () => {
          this.toast("", "تم تعديل كلمة المرور بنجاح");
        },
      });
    },
  },
};
</script>
