<template>
  <div class="w-full h-full overflow-hidden bg-gray-200">
    <main
      class="fixed top-14 h-[87%] p-2 bg-transparent gap-2 left-0 transition-all duration-500 overflow-auto"
      :class="showSideBar ? 'w-[85%]' : 'w-[95%]'"
    >
      <div class="relative w-full h-full">
        <slot></slot>
      </div>
    </main>
    <div
      class="fixed top-0 left-0 grid h-12 grid-cols-12 gap-2 transition-all duration-500 bg-white shadow-md"
      :class="showSideBar ? 'w-[85%]' : 'w-[95%]'"
    >
      <div class="flex items-center justify-start h-full col-span-2 px-2">
        <Icon icon="basil:notification-outline" class="h-8" />
      </div>
      <div class="col-span-6 h-full flex items-center justify-center">
        <!-- <p class="text-xl font-serif font-semibold">نظام موارد بشرية</p> -->
      </div>
      <div class="flex items-center h-full col-span-4 justify-evenly">
        <div class="h-8 w-52">
          <DropdownList v-if="$page.props.role == 'admin'" classes="border-2">
            <template #button>
              <div class="cursor-pointer py-0.5 px-2 text-xs">
                {{ currentItem }}
              </div>
            </template>
            <template #items>
              <DropDownOption
                v-for="item in branshes"
                :key="item.id"
                class="text-xs hover:bg-primary hover:text-white"
                :select="(v) => selectBransh(item.id)"
              >
                {{ item.name }}
              </DropDownOption>
            </template>
          </DropdownList>
        </div>
        <div
          @click="logout"
          class="flex items-center justify-center cursor-pointer h-max justify-self-end"
        >
          <Icon :rotate="2" icon="carbon:logout" class="h-8" />
        </div>
      </div>
    </div>
    <div
      class="fixed right-0 grid h-full gap-2 transition-all duration-500 bg-primary rounded-l-md grid-rows-12"
      :class="showSideBar ? 'w-44' : 'w-14'"
    >
      <div class="relative row-span-1">
        <div
          @click="showSideBar = !showSideBar"
          class="absolute z-50 flex items-center justify-center w-6 h-6 rounded-full cursor-pointer top-10 bg-slate-600 -left-3"
        >
          <Icon
            icon="ic:round-arrow-back-ios"
            :rotate="!showSideBar ? 0 : 2"
            class="text-white"
          />
        </div>
      </div>
      <div class="row-span-5 truncate">
        <div class="flex items-center w-40 mx-auto text-white truncate">
          <p
            class="px-4 w-full font-serif font-semibold transition-all duration-300"
            :class="showSideBar ? 'text-4xl text-center' : 'text-xl'"
          >
            HR<span v-show="showSideBar">MS</span>
          </p>
        </div>
      </div>
      <div class="flex flex-col items-stretch row-span-6 truncate">
        <NavLink icon="carbon:home" href="/" title="الرئيسيه" />
        <NavLink
          v-if="$page.props.role == 'admin'"
          icon="carbon:calendar-heat-map"
          href="/shifts"
          title="الدوام"
        />
        <NavLink
          v-if="$page.props.role == 'admin'"
          icon="carbon:inventory-management"
          href="/management"
          title="الادارات"
        />
        <NavLink icon="humbleicons:users" href="/employees" title="الموظفين" />
        <NavLink icon="ph:fingerprint-thin" href="/migration" title="البصمات" />
        <NavLink
          icon="iconoir:stats-report"
          href="/report"
          title="تقرير الحضور"
        />
       
        <NavLink
          icon="icon-park-outline:vacation"
          href="/vacations"
          title="الاجازات"
        />
        <NavLink
          icon="fluent:tasks-app-20-regular"
          href="/tasks"
          title="التكاليف"
        />
       
        <NavLink
          v-if="$page.props.role == 'admin'"
          icon="ep:setting"
          href="/setting"
          title="الاعدادات"
        />
      </div>
      <div
        class="flex flex-col items-center justify-end row-span-3 pb-4 truncate"
      >
        <div
          class="flex items-center w-40 mx-auto my-2 text-white no-underline truncate hover:underline"
        >
          <Icon icon="carbon:user" class="h-6 px-4 w-14" />
          {{ $page.props.auth.user.name.split(" ")[0] }}
          <!-- <p v-html="$page.props?.auth?.user?.name"></p> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DropdownList from "../Components/Form/DropDown/DropdownList.vue";
import DropDownOption from "../Components/Form/DropDown/DropDownOption.vue";
import NavLink from "../Components/Layout/Navigation/NavLink.vue";
import { Icon } from "@iconify/vue";
import { Link, router } from "@inertiajs/vue3";
export default {
  name: "AppLayout",
  components: {
    Icon,
    Link,
    NavLink,
    DropdownList,
    DropDownOption,
  },
  data: () => ({
    currentItem: null,
    showSideBar: false,
    branshes: [],
  }),
  async created() {
    await this.getBranshes();
    this.currentItem = this.branshes.find(
      (v) => v.id == window.sessionStorage.getItem("bransh")
    )?.name;
  },
  methods: {
    selectBransh(id) {
      this.currentItem = this.branshes.find((v) => v.id == id).name;
      window.sessionStorage.setItem("bransh", id);
      this.$inertia.post("/bransh-session/" + id);
      window.location.reload();
    },
    async getBranshes() {
      await axios.get("/get_bransh").then((res) => {
        this.branshes = res.data;
      });
    },
    logout() {
      router.post(this.route("logout"));
    },
  },
};
</script>
