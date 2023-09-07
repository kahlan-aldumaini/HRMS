
<template>
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
        :class="showAddNew ? '-translate-x-1/2 ' : '-translate-x-1/3 '"
      >
        <div class="flex items-center jusc">
          <div
            class="px-4 py-2 mt-2 mb-4 text-xl font-semibold text-center w-max"
          >
            اضافة اجازه
          </div>
        </div>

        <form @submit.prevent="submit" class="px-2 w-[500px]">
          <div v-if="$page.props.role != 'employee'" class="w-full mb-4">
            <span class="block mb-4 mr-4 text-sm font-semibold"
              >نوع الفئة</span
            >
            <div class="flex items-center justify-evenly">
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
              <label class="flex items-center px-4">
                <input
                  type="radio"
                  value="group"
                  name="type"
                  v-model="newEmpFingerprint.type"
                  class="pr-1 text-sm bg-transparent border focus:ring-0 text-primary"
                />
                <span class="mr-2">مجموعة محدده</span>
              </label>
              <label class="flex items-center px-4">
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
          <div class="grid w-full grid-cols-2 gap-2">
            <label
              v-if="
                newEmpFingerprint.type == 'employee' &&
                $page.props.role != 'employee'
              "
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
                      {{ item.user.name }}
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
              <span class="block mb-1 mr-4 text-sm font-semibold"
                >الاجازات</span
              >
              <div class="px-2 border rounded-md">
                <DropdownList>
                  <template #button>
                    <div class="px-1">{{ currentVacation }}</div>
                  </template>
                  <template #items>
                    <DropDownOption
                      class="hover:bg-blue-500"
                      v-for="item in Vactions"
                      :key="item.id"
                      :select="
                        (e) => {
                          newEmpFingerprint.vaction = item.id;
                          currentVacation = item.name;
                        }
                      "
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

            <label
              v-if="newEmpFingerprint.type == 'group'"
              class="block w-full mb-4"
            >
              <span class="block mb-1 mr-4 text-sm font-semibold"
                >المجموعة</span
              >
              <div class="px-2 border rounded-md">
                <DropdownList>
                  <template #button>
                    <div class="px-1">{{ currentGroup }}</div>
                  </template>
                  <template #items>
                    <DropDownOption
                      class="hover:bg-blue-500"
                      v-for="item in groups"
                      :key="item.id"
                      :select="
                        (e) => {
                          newEmpFingerprint.group = item.id;
                          currentGroup = item.name;
                          getShiftByGroupOrEmployee(item.id);
                        }
                      "
                    >
                      {{ item.name }}
                    </DropDownOption>
                  </template>
                </DropdownList>
              </div>
              <small
                v-if="newEmpFingerprint.errors.group != null"
                class="mt-1 mr-4 text-xs font-semibold text-red-800"
                v-html="newEmpFingerprint.errors.group"
              ></small>
            </label>

            <label class="block w-full mb-4">
              <span class="block mb-1 mr-4 text-sm font-semibold"
                >تاريخ البدء</span
              >
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
              <span class="block mb-1 mr-4 text-sm font-semibold"
                >تاريخ الانتهاء</span
              >
              <div class="flex items-center px-4 border rounded-md">
                <input
                  type="date"
                  v-model="newEmpFingerprint.exit"
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
          <div class="flex items-center justify-between w-full py-2">
            <BlueButton type="submit"> حفظ </BlueButton>
            <button
              type="reset"
              @click="
                showAddNew = false;
                newEmpFingerprint.reset();
              "
              class="w-full py-2 mx-2 text-sm font-semibold text-white bg-red-500 rounded-full"
            >
              الغاء
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <Filter
    :show="showFilter"
    :filter="filterData"
    :hide="hideFilter"
    url="/vacations"
    :success="filterSuccess"
    :only="filterKeys"
  >
    <template #header> فلتر الاجازات </template>
  </Filter>

  <ShowModel
    :show="showVacation"
    title="عرض الاجازه"
    :items="vacationData"
    :hide="hideShowVacationModel"
  />

  <TableCard>
    <template #header>
      <div class="flex items-center justify-between w-full">
        <p class="text-xl font-semibold">عرض الاجازات</p>
        <div class="grid grid-cols-3 gap-2">
          <BlueButton
            v-if="employees.length"
            @click="
              showAddNew = true;
              getEmployees();
            "
            class="px-4 py-1"
          >
            اضافة اجازه
          </BlueButton>
          <secondary-button @click="showFilter = true"> فلتر </secondary-button>
          <danger-button :loading="loadingClearFilter" @click="clearFilter">
            تصفية الفلتر
          </danger-button>
        </div>
      </div>
    </template>
    <template #table_header>
      <th>الاسم</th>
      <th class="py-2">رقم الكود</th>
      <th>نوع الاجازة</th>
      <th>تاريخ البدء</th>
      <th>تاريخ الانتهاء</th>
      <th>حالة الاجازة</th>
      <th>تمت الموافقة</th>
      <th>خيارات</th>
    </template>
    <template #table_body>
      <tr
        class="py-2 text-center border-b-2 h-14"
        v-for="item in fingerprints"
        :key="item.id"
      >
        <td>{{ item.user_name }}</td>
        <td>{{ item.code }}</td>
        <td>{{ item.type }}</td>
        <td>{{ item.start }}</td>
        <td>{{ item.end }}</td>
        <td>{{ item.state }}</td>
        <td>{{ item.approved ? "تمت الموافقة" : "في الانتظار" }}</td>
        <td class="flex items-center justify-evenly h-14">
          <div
            class="cursor-pointer hover:underline"
            @click="showVacationFunction(item.id)"
          >
            عرض
          </div>

          <div
            v-if="!item.approved && $page.props.role == 'manager'"
            class="cursor-pointer hover:underline"
            @click="approved(item.id)"
          >
            موافقة
          </div>
        </td>
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
import SecondaryButton from "@/Components/Buttons/SecondaryButton.vue";
import DangerButton from "@/Components/Buttons/DangerButton.vue";
import FormDropDown from "@/Components/Form/DropDown/FormDropDown.vue";
import ShowModel from "@/Components/Models/ShowModel.vue";
import Filter from "@/Components/Models/Filter/Filter.vue";

export default {
  components: {
    TableCard,
    Icon,
    BlueButton,
    DropdownList,
    DropDownOption,
    SecondaryButton,
    DangerButton,
    FormDropDown,
    ShowModel,
    Filter,
  },
  props: {
    fingerprints: Array,
    filter: Object,
  },
  created() {
    this.getEmployees();
    if (this.$page.props.role == "employee") {
      this.newEmpFingerprint.type = "employee";
      this.newEmpFingerprint.employee = this.$page.props.emp_id;
      this.currentEmp = this.$page.props.auth.user.name;
      this.getShiftByGroupOrEmployee(this.$page.props.auth.user.id);
    }
  },
  data() {
    return {
      showAddNew: false,
      employees: [],
      currentEmp: "",
      Vactions: [],
      groups: [],
      currentVacation: "",
      currentGroup: "",
      newEmpFingerprint: useForm({
        employee: "",
        hours: "",
        login: "",
        exit: "",
        type: "",
        vaction: "",
        group: "",
        shift_id: "",
      }),
      shifts: [],
      editId: 0,
      vacationData: null,
      showVacation: false,

      // filter
      showFilter: false,
      loadingClearFilter: false,
      filterKeys: ["group", "from_date", "to_date"],
      filterData: this.filter,
    };
  },
  watch: {
    "newEmpFingerprint.type": function (val) {
      this.getVacations();
      if (val == "employee") this.getEmployees();
      else if (val == "group") this.getGroup();
    },
  },
  methods: {
    hideFilter() {
      this.showFilter = false;
    },
    filterSuccess() {
      this.toast("", "تم فلترة  الاجازات بنجاح");
      this.hideFilter();
    },
    clearFilter() {
      this.loadingClearFilter = true;
      router.get(
        "/vacations",
        {},
        {
          onSuccess: () => {
            this.toast("", "تم تصفية فلتر الاجازات بنجاح");
            this.loadingClearFilter = false;
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
      this.currentEmp = item.user.name;
      this.newEmpFingerprint.employee = item.id;
      this.getVacations();
      this.getShiftByGroupOrEmployee(item.id);
    },
    submit() {
      this.newEmpFingerprint.post("/add-new-vaction", {
        onSuccess: () => {
          this.showAddNew = false;
          this.toast("", "تمت اضافة الاجازة بنجاح");
        },
        onError: (er) => {
          if (er.message) {
            this.toast("", er.message, "error");
          }
        },
      });
    },
    getVacations() {
      if (this.newEmpFingerprint.type == "employee")
        axios
          .get("/get-vacations-for-emp/" + this.newEmpFingerprint.employee)
          .then((res) => {
            this.Vactions = res.data;
          })
          .catch((err) => console.log(err));
      else
        axios
          .get("/get-vacations/")
          .then((res) => {
            this.Vactions = res.data;
          })
          .catch((err) => console.log(err));
    },
    getGroup() {
      axios
        .get("/get-groups")
        .then((res) => {
          this.groups = res.data;
        })
        .catch((err) => console.log(err));
    },
    async getShiftByGroupOrEmployee(id) {
      await axios
        .get("/get-shift?id=" + id + "&type=" + this.newEmpFingerprint.type)
        .then((res) => {
          this.shifts = res.data;
        });
    },
    async showVacationFunction(id) {
      this.showVacation = true;
      this.editId = id;
      await axios.get("/get-vacation/" + id).then((res) => {
        this.vacationData = res.data;
      });
    },
    hideShowVacationModel() {
      this.showVacation = false;
      this.editId = 0;
      this.vacationData = null;
    },
    approved(id) {
      router.get(
        "/approved-vacation/" + id,
        {},
        {
          onSuccess: (v) => {
            this.toast("", "تمت الموافقة على الاجازة");
          },
        }
      );
    },
  },
};
</script>
