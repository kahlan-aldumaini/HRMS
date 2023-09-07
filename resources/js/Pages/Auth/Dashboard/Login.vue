<template>
  <div class="w-screen h-screen flex items-center justify-center bg-gray-200">
    <form
      @submit.prevent="form.post('/login')"
      method="post"
      class="bg-white rounded-xl shadow-xl shadow-indigo-200 min-w-52 min-h-max px-6 py-4"
    >
      <div class="w-full py-2 text-center font-bold border-b-2 mb-4">
        <h1 class="text-xl">تسجيل الدخول</h1>
      </div>
      <label class="w-full block mb-4">
        <span class="text-sm block font-semibold mb-1 mr-4">اسم المستخدم</span>
        <div class="flex rounded-full bg-blue-200 items-center px-4">
          <Icon icon="carbon:user" class="text-indigo-900" />
          <input
            type="text"
            v-model="form.user_name"
            class="focus:ring-0 border-0 pr-1 text-sm bg-transparent"
          />
        </div>
        <small
          v-if="form.errors.user_name != null"
          class="text-red-800 text-xs mt-1 mr-4 font-semibold"
          v-html="form.errors.user_name"
        ></small>
      </label>
      <label class="w-full block">
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
      <Link
        href="/forgate-password"
        class="mb-5 block text-sm px-2 mt-1 text-gray-900 hover:underline"
      >
        هل نسيت كلمة المرور؟
      </Link>
      <BlueButton> تسجيل الدخول </BlueButton>
    </form>
  </div>
</template>
<script>
import { useForm, Link } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import BlueButton from "@/Components/Form/Buttons/BlueButton.vue";

export default {
  name: "Login",
  components: {
    Icon,
    BlueButton,
    Link,
  },
  data: () => ({
    form: useForm({
      user_name: "",
      password: "",
    }),
    showPassword: false,
  }),
  methods: {
    submit() {
      this.form.post("/login", {
        onFinish: () => {
          // TODO: add notification
        },
      });
    },
  },
};
</script>
