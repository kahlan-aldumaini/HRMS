<template>
  <Model :show="showDeleteModel" :hide="hideModel">
    <template #title> تأكيد الحذف </template>
    <div>Do you want to delete this employee?</div>
    <template #footer>
      <div class="w-full grid grid-cols-2 gap-4">
        <SecondaryButton @click="hideModel"> الغاء </SecondaryButton>
        <DangerButton @click="deleteEmp"> حذف </DangerButton>
      </div>
    </template>
  </Model>
  <Model :show="showAddToGroup" :hide="hideAddToGroup">
    <template #title> اضافة الى مجموعة </template>
    <div>
      <label class="block w-full mb-4">
        <span class="block mb-1 mr-4 text-sm font-semibold">المجموعة</span>
        <div class="px-2 border rounded-md">
          <dropdown-list>
            <template #button>
              <div class="px-1">
                {{
                  groups.find((v) => v.id == addToGroup.group_of_sets_id)?.name
                }}
              </div>
            </template>
            <template #items>
              <drop-down-option
                class="hover:bg-blue-500"
                v-for="item in groups"
                :key="item.id"
                :select="(e) => (addToGroup.group_of_sets_id = item.id)"
              >
                {{ item.name }}
              </drop-down-option>
            </template>
          </dropdown-list>
        </div>
        <small
          v-if="addToGroup.errors.group_of_sets_id != null"
          class="mt-1 mr-4 text-xs font-semibold text-red-800"
          v-html="addToGroup.errors.group_of_sets_id"
        ></small>
      </label>
      <div class="grid grid-cols-2 gap-4 w-max">
        <label class="block w-full mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">تاريخ البدء</span>
          <div class="flex items-center px-4 border rounded-md">
            <input
              type="date"
              v-model="addToGroup.start"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="addToGroup.errors.start != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="addToGroup.errors.start"
          ></small>
        </label>

        <label class="block w-full mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"
            >تاريخ الانتهاء</span
          >
          <div class="flex items-center px-4 border rounded-md">
            <input
              type="date"
              v-model="addToGroup.end"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="addToGroup.errors.end != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="addToGroup.errors.end"
          ></small>
        </label>
      </div>
    </div>
    <template #footer>
      <div class="grid grid-cols-2 gap-4 w-full">
        <SecondaryButton @click="submitAddToGroup"> حفط </SecondaryButton>
        <DangerButton @click="hideAddToGroup"> الغاء </DangerButton>
      </div>
    </template>
  </Model>
  <show-model
    :hide="hideShowEmpModel"
    :items="employeeData"
    title="عرض بيانات الموظف"
    :show="showEmpModel"
  />
  <div class="flex items-center justify-between w-full h-full bg-gray-200">
    <div v-if="$page.props.role == 'admin'" class="w-3/12 h-full p-1 pl-4">
      <SideCard
        label="اضافة موظف"
        @back="back"
        @show="show"
        :is-child="!addNewEmployee"
      />
    </div>
    <div
      :class="$page.props.role == 'admin' ? 'w-9/12' : 'w-full'"
      class="h-full p-1 px-2 overflow-auto"
    >
      <Loading v-if="loading" />
      <TableCard v-if="!addNewEmployee">
        <template #table_header>
          <th class="py-2">#</th>
          <th class="py-2">اسم الموظف</th>
          <th class="py-2">اسم الوظيفيه</th>
          <th class="py-2">الفرع</th>
          <th class="py-2">القسم</th>
          <th class="py-2">رقم الهاتف</th>
          <th class="py-2">الحالة</th>
          <th class="py-2">المجموعة</th>
          <th class="py-2">الخيارات</th>
        </template>
        <template #table_body>
          <tr
            v-for="item in employees"
            :key="item.id"
            class="text-center truncate rounded-md hover:bg-slate-100"
          >
            <td v-html="item.employee_number" class="h-8 py-2"></td>
            <td v-html="item.name" class="h-8 py-2"></td>
            <td v-html="item.job_name" class="h-8 py-2"></td>
            <td v-html="item.bransh" class="h-8 py-2"></td>
            <td v-html="item.department" class="h-8 py-2"></td>
            <td v-html="item.phone" class="h-8 py-2"></td>
            <td v-html="item.state" class="h-8 py-2"></td>
            <td v-html="item.group" class="h-8 py-2"></td>
            <td class="flex items-center h-8 py-2 justify-evenly">
              <div
                v-if="$page.props.role == 'admin'"
                @click="editEmp(item.id)"
                class="cursor-pointer text-slate-500 hover:text-primary hover:font-semibold"
              >
                <Icon icon="carbon:edit" />
              </div>
              <div
                @click="showEmp(item.id)"
                class="cursor-pointer text-slate-500 hover:text-primary hover:font-semibold"
              >
                <Icon icon="iconamoon:eye" />
              </div>
              <div
                v-if="item.doesnetHaveGroup"
                @click="showAddToGroupFun(item.id)"
                class="cursor-pointer text-slate-500 hover:text-primary hover:font-semibold"
              >
                اضافة مجموعة
              </div>
              <!-- <div @click="showModel(item.id)"
                                class="text-red-500 cursor-pointer hover:text-red-700 hover:font-semibold">
                                حذف
                            </div> -->
            </td>
          </tr>
        </template>
      </TableCard>
      <AddNew :employee="employee" v-else />
    </div>
  </div>
</template>
<script>
import AppLayout from "../../../Layouts/AppLayout.vue";
import { Icon } from "@iconify/vue";
import SideCard from "../../../Components/Pages/SideCard.vue";
import BlueButton from "@/Components/Form/Buttons/BlueButton.vue";
import GroupOfContinuity from "@/Components/Pages/Continuity/GroupOfContinuity.vue";
import Loading from "@/Components/Form/Loading.vue";
import axios from "axios";
import AddNew from "./AddNew.vue";
import TableCard from "@/Components/Layout/Card/TableCard.vue";
import { Link, router, useForm } from "@inertiajs/vue3";
import Model from "@/Components/Models/Model.vue";
import DangerButton from "@/Components/Buttons/DangerButton.vue";
import SecondaryButton from "@/Components/Buttons/SecondaryButton.vue";
import ShowModel from "@/Components/Models/ShowModel.vue";
import DropDownOption from "@/Components/Form/DropDown/DropDownOption.vue";
import DropdownList from "@/Components/Form/DropDown/DropdownList.vue";

export default {
  components: {
    AppLayout,
    Icon,
    SideCard,
    BlueButton,
    GroupOfContinuity,
    Loading,
    AddNew,
    TableCard,
    Link,
    Model,
    DangerButton,
    SecondaryButton,
    ShowModel,
    DropDownOption,
    DropdownList,
  },
  layout: AppLayout,
  data() {
    return {
      addNewEmployee: false,
      employees: [],
      loading: false,
      showAddToGroup: false,
      groups: [],
      editId: null,
      employee: null,
      showDeleteModel: false,
      showEmpModel: false,
      employeeData: null,
      addToGroup: useForm({ group_of_sets_id: null, start: null, end: null }),
    };
  },
  created() {
    axios.get("/get-employees").then((res) => {
      for (const item of res.data) {
        this.employees.push({
          id: item.id,
          name: item.name,
          job_name: item.job_data?.[0]?.name,
          bransh: item?.bransh?.management[0]?.bransh?.name,
          department: item?.bransh?.management[0]?.name,
          phone: item.phone,
          state: item.state,
          group: `${item?.groups?.[0]?.name} - ${item?.groups?.[0]?.id}`,
          employee_number: item.employee_number,
          doesnetHaveGroup: item.doesnetHaveGroup,
        });
      }
    });
  },
  methods: {
    showModel(id) {
      this.editId = id;
      this.showDeleteModel = true;
    },
    hideModel() {
      this.showDeleteModel = false;
      this.editId = null;
    },
    async showAddToGroupFun(id) {
      this.showAddToGroup = true;
      this.editId = id;
      await axios.get("/get-groups").then((res) => (this.groups = res.data));
    },
    hideAddToGroup() {
      this.showAddToGroup = false;
      this.groups = [];
    },
    deleteEmp() {
      router.get(
        "/delete-employee/" + this.editId,
        {},
        {
          onSuccess: () => {
            this.hideModel();
            this.toast("", "تم حذف الموظف بنجاح");
          },
        }
      );
    },
    async editEmp(id) {
      await axios
        .get("/get-employee/" + id)
        .then((res) => {
          this.employee = res.data;
        })
        .catch((err) => console.log(err));
      this.show();
    },
    show() {
      this.addNewEmployee = true;
    },
    back() {
      this.addNewEmployee = false;
      this.groups = [];
      this.employee = null;
      this.editId = null;
    },
    async showEmp(id) {
      this.showEmpModel = true;
      await axios
        .get("/show-employee/" + id)
        .then((res) => (this.employeeData = res.data));
    },
    hideShowEmpModel() {
      this.showEmpModel = false;
      this.employeeData = null;
    },
    submitAddToGroup() {
      this.addToGroup.post(`/add-to-group/${this.editId}`, {
        onSuccess: (v) => {
          this.hideAddToGroup();
          this.toast("", "تم اضافة الموظف الى مجموعة");
        },
        onError: (v) => {
          if (v.message) this.toast("", v.message, "error");
        },
      });
    },
  },
};
</script>
