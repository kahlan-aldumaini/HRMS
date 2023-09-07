
<template>
  <Filter
    :show="showFilter"
    :filter="filterData"
    :hide="hideFilter"
    url="/migration"
    :success="filterSuccess"
    :only="filterKeys"
  >
    <template #header> فلتر البصمات </template>
  </Filter>
  <div
    class="absolute top-0 right-0 w-full h-full transition-all duration-300 ease-linear cursor-pointer"
    :class="showAddNew ? 'z-50' : '-z-50'"
  >
    <div class="relative w-full h-full">
      <div
        class="absolute w-full h-full bg-gray-200 opacity-75"
        @click="showAddNew = false"
      ></div>
      <div
        class="absolute transition-all duration-500 -translate-y-1/2 bg-white border shadow-lg w-max top-1/2 left-1/2 h-max rounded-xl"
        :class="showAddNew ? '-translate-x-1/2 ' : '-translate-x-full '"
      >
        <div class="flex items-center jusc">
          <div
            class="px-4 py-2 mt-2 mb-4 text-xl font-semibold text-center w-max"
          >
            اضافة حركة
          </div>
        </div>
        <form @submit.prevent="submit" class="px-4">
          <div class="grid w-full grid-cols-1 gap-2 mb-4">
            <span class="block mb-4 mr-4 text-sm font-semibold"
              >نوع الحركة</span
            >
            <div class="flex items-center justify-center">
              <label class="flex items-center px-4">
                <input
                  type="radio"
                  value="employee"
                  name="type"
                  v-model="newEmpFingerprint.type"
                  class="pr-1 text-sm bg-transparent border focus:ring-0"
                />
                <span class="mr-2"> موظف محدد </span>
              </label>
              <label class="flex items-center px-4 mt-2">
                <input
                  @change="getShiftByGroupOrEmployee(0)"
                  type="radio"
                  value="all"
                  name="type"
                  v-model="newEmpFingerprint.type"
                  class="pr-1 text-sm bg-transparent border focus:ring-0 text-primary"
                />
                <span class="mr-2">كل الموظفين</span>
              </label>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-2 w-max">
            <label
              v-if="newEmpFingerprint.type == 'employee'"
              class="block w-full mb-4"
            >
              <span class="block mb-1 mr-4 text-sm font-semibold"
                >اسم الموظف</span
              >
              <div class="px-2 border rounded-md">
                <DropdownList>
                  <template #button>
                    <div class="px-1">{{ currentEmp }}</div>
                  </template>
                  <template #items>
                    <DropDownOption
                      class="hover:bg-blue-500"
                      v-for="item in employees"
                      :key="item.id"
                      :select="(e) => selectFun(item)"
                    >
                      {{ item.name }}
                    </DropDownOption>
                  </template>
                </DropdownList>
              </div>
              <small
                v-if="newEmpFingerprint.errors.employee != null"
                class="mt-1 mr-4 text-xs font-semibold text-red-800"
                v-html="newEmpFingerprint.errors.employee"
              ></small>
            </label>

            <label class="block w-full mb-4">
              <span class="block mb-1 mr-4 text-sm font-semibold">الحركة</span>
              <div class="px-2 border rounded-md">
                <DropdownList>
                  <template #button>
                    <div class="px-1">{{ newEmpFingerprint?.movement }}</div>
                  </template>
                  <template #items>
                    <DropDownOption
                      class="hover:bg-blue-500"
                      v-for="item in fingerprintMovement"
                      :key="item.id"
                      :select="
                        (e) => {
                          newEmpFingerprint.movement = item.name;
                        }
                      "
                    >
                      {{ item.name }}
                    </DropDownOption>
                  </template>
                </DropdownList>
              </div>
              <small
                v-if="newEmpFingerprint.errors.movement != null"
                class="mt-1 mr-4 text-xs font-semibold text-red-800"
                v-html="newEmpFingerprint.errors.movement"
              ></small>
            </label>

            <label class="block w-full mb-4">
              <span class="block mb-1 mr-4 text-sm font-semibold">من</span>
              <div class="flex items-center px-4 border rounded-md">
                <input
                  type="date"
                  v-model="newEmpFingerprint.login"
                  class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
                />
              </div>
              <small
                v-if="newEmpFingerprint.errors.login != null"
                class="mt-1 mr-4 text-xs font-semibold text-red-800"
                v-html="newEmpFingerprint.errors.login"
              ></small>
            </label>

            <label class="block w-full mb-4">
              <span class="block mb-1 mr-4 text-sm font-semibold">الى</span>
              <div class="flex items-center px-4 border rounded-md">
                <input
                  type="date"
                  v-model="newEmpFingerprint.exit"
                  :min="newEmpFingerprint.login"
                  class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
                />
              </div>
              <small
                v-if="newEmpFingerprint.errors.exit != null"
                class="mt-1 mr-4 text-xs font-semibold text-red-800"
                v-html="newEmpFingerprint.errors.exit"
              ></small>
            </label>
          </div>

          <FormDropDown
            label="الوردية"
            :modelValue="newEmpFingerprint.shift_id"
            :error="newEmpFingerprint.errors.shift_id"
            :selectData="shifts"
            :selectFun="(v) => (newEmpFingerprint.shift_id = v)"
          />
          <div class="flex items-center justify-between py-2">
            <BlueButton type="submit"> حفظ </BlueButton>
            <button
              type="reset"
              @click="showAddNew = false"
              class="w-full py-2 mx-2 text-sm font-semibold text-white bg-red-500 rounded-full"
            >
              الغاء
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <TableCard>
    <template #header>
      <div class="flex items-center justify-between w-full">
        <p class="text-xl font-semibold">عرض البصمات</p>
        <div class="grid grid-cols-3 gap-2">
          <secondary-button @click="showFilter = true"> فلتر </secondary-button>
          <danger-button :loading="loadingClearFilter" @click="clearFilter">
            تصفية الفلتر
          </danger-button>
          <div v-if="employees.length && $page.props.role != 'employee'">
            <BlueButton
              @click="
                showAddNew = true;
                getEmployees();
              "
              class="px-4 py-1"
            >
              اضافة حركة
            </BlueButton>
          </div>
        </div>
      </div>
    </template>
    <template #table_header>
      <th>الاسم</th>
      <th class="py-2">اسم المجموعة</th>
      <th>اليوم</th>
      <th>اسم الوردية</th>
      <th>وقت الدخول</th>
      <th>وقت الخروج</th>
      <th>رقم الجهاز</th>
    </template>
    <template #table_body>
      <tr
        class="py-2 text-center border-b-2 h-14"
        v-for="item in fingerprints"
        :key="item.id"
      >
        <td>{{ item.user_name }}</td>
        <td>{{ item.group_name }}</td>
        <td>{{ item.day }}</td>
        <td>{{ item.shift_name }}</td>
        <td>{{ item.enter_time }}</td>
        <td>{{ item.exit_time }}</td>
        <td>{{ item.device_number }}</td>
      </tr>
    </template>
  </TableCard>
</template>
<script>
import TableCard from "@/Components/Layout/Card/TableCard.vue";
import { useForm, Link, router } from "@inertiajs/vue3";
import axios from "axios";
import { Icon } from "@iconify/vue";
import BlueButton from "@/Components/Form/Buttons/BlueButton.vue";
import DropdownList from "@/Components/Form/DropDown/DropdownList.vue";
import DropDownOption from "@/Components/Form/DropDown/DropDownOption.vue";
import FormDropDown from "@/Components/Form/DropDown/FormDropDown.vue";
import DangerButton from "@/Components/Buttons/DangerButton.vue";
import SecondaryButton from "@/Components/Buttons/SecondaryButton.vue";
import Filter from "@/Components/Models/Filter/Filter.vue";

export default {
  components: {
    TableCard,
    Icon,
    BlueButton,
    DropdownList,
    DropDownOption,
    FormDropDown,
    DangerButton,
    SecondaryButton,
    Filter,
  },
  props: {
    fingerprints: Array,
    filter: Object,
  },
  created() {
    this.getEmployees();
  },
  data() {
    return {
      showAddNew: false,
      employees: [],
      currentEmp: "",
      fingerprintMovement: [
        {
          id: 1,
          name: "تكليف بصمة دخول",
        },
        {
          id: 2,
          name: "تكليف بصمة خروج",
        },
        {
          id: 3,
          name: "احتساب دخول بدون جزاء",
        },
        {
          id: 4,
          name: "احتساب خروج بدون جزاء",
        },
        {
          id: 5,
          name: "خصم يوم جزاء",
        },
        {
          id: 6,
          name: "خصم يومين جزاء",
        },
        {
          id: 7,
          name: "خصم ثلاثة جزاء",
        },
      ],
      newEmpFingerprint: useForm({
        employee: "",
        movement: null,
        login: "",
        exit: "",
        type: "employee",
        shift_id: "",
      }),
      shifts: [],

      // filter
      showFilter: false,
      loadingClearFilter: false,
      filterKeys: ["group"],
      filterData: this.filter,
    };
  },
  methods: {
    clearFilter() {
      this.loadingClearFilter = true;
      router.get(
        "/migration",
        {},
        {
          onSuccess: () => {
            this.loadingClearFilter = false;
            this.filterData = [];
          },
        }
      );
    },
    getEmployees() {
      axios
        .get("/get-employees")
        .then((res) => {
          this.employees = res.data;
        })
        .catch((err) => console.log(err));
    },
    selectFun(item) {
      this.currentEmp = item.name;
      this.newEmpFingerprint.employee = item.id;
      this.getShiftByGroupOrEmployee(item.id);
    },
    submit() {
      this.newEmpFingerprint.post("/add-new-fingerprint", {
        onSuccess: () => {
          this.showAddNew = false;
          // add notification
          this.toast("", "تم اضافة الحركة بنجاح", "success");
          this.newEmpFingerprint.reset();
        },
      });
    },
    async getShiftByGroupOrEmployee(id) {
      await axios
        .get("/get-shift?id=" + id + "&type=" + this.newEmpFingerprint.type)
        .then((res) => {
          this.shifts = res.data;
        });
    },
  },
};
</script>
