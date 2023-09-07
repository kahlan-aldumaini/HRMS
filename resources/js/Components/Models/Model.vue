<template>
  <div
    :class="!show ? '-z-[9999999]' : 'z-50'"
    class="fixed w-screen h-screen transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
  >
    <div class="relative w-full h-full">
      <div
        @click="hide(false)"
        class="w-full h-full transition-all duration-500 ease-in-out cursor-pointer"
        :class="show ? 'bg-gray-900 bg-opacity-30' : ''"
      ></div>
      <div
        :class="show ? 'left-1/2 -translate-x-1/2' : 'left-0 -translate-x-full'"
        class="absolute w-5/6 transition-transform duration-500 ease-in-out transform -translate-y-1/2 bg-gray-100 rounded-lg md:w-auto top-1/2"
      >
        <div class="flex items-center w-full">
          <div
            class="relative flex items-center justify-end h-10 px-6 pt-6 text-xl font-semibold cursor-pointer"
            @click="hide(false)"
          >
            <span
              class="w-4 h-0.5 bg-gray-500 hover:bg-gray-700 rounded-md absolute top-6 right-6 rotate-45"
            ></span>
            <span
              class="w-4 h-0.5 bg-gray-500 hover:bg-gray-700 rounded-md absolute top-6 right-6 -rotate-45"
            ></span>
          </div>

          <div class="w-4/5 py-4 text-xl font-semibold text-center pl-6">
            <slot name="title"></slot>
          </div>
        </div>
        <div class="p-4">
          <slot />
        </div>
        <div class="p-4">
          <slot name="footer"></slot>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "Model",
  props: {
    show: { type: Boolean },
    hide: { type: Function },
  },
};
</script>
