<template>
  <div class="w-screen h-screen flex items-center justify-center bg-gray-200">
    <form
      @submit.prevent="submit"
      method="post"
      class="bg-white rounded-xl shadow-xl shadow-indigo-200 min-w-52 min-h-max px-6 py-4"
    >
      <div class="w-full py-2 text-center font-bold border-b-2 mb-4">
        <h1 class="text-xl">التحقق من كلمة المرور</h1>
      </div>
      <label class="w-full block mb-4">
        <span class="text-sm block font-semibold mb-1 mr-4">الايميل</span>
        <div class="flex rounded-full bg-blue-200 items-center px-4">
          <Icon icon="eva:email-outline" class="text-indigo-900" />
          <input
            type="text"
            v-model="form.email"
            class="focus:ring-0 border-0 pr-1 text-sm bg-transparent"
          />
        </div>
        <small
          v-if="form.errors.email != null"
          class="text-red-800 text-xs mt-1 mr-4 font-semibold"
          v-html="form.errors.email"
        ></small>
      </label>
      <BlueButton> ارسال رمز التحقق</BlueButton>
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
      email: "",
    }),
  }),
  methods: {
    submit() {
      this.form.post("/forgate-password", {
        onSuccess: () => {
          this.toast("", "تم ارسال رسالة التحقق الي البريد الالكتروني");
        },
        onError: (v) => {
          if (v.message) this.toast("", v.message, "error");
        },
      });
    },
  },
};
</script>
