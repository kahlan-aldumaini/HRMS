
<template>
  <Filter
    :show="showFilter"
    :filter="filterData"
    :hide="hideFilter"
    url="/shifts"
    :success="filterSuccess"
    :only="filterKeys"
  >
    <template #header> فلتر الموظف </template>
  </Filter>
  <Model :show="showAddGroup" :hide="hideAddGroup">
    <template #title>
      {{ editId ? "تعديل المجموعة" : "انشاء مجموعة" }}
    </template>
    <form class="p-6">
      <label class="block w-full mb-4">
        <span class="block mb-1 mr-4 text-sm font-semibold">اسم المجموعة</span>
        <div class="flex items-center px-4 bg-blue-100 rounded-md">
          <input
            type="text"
            v-model="newGroupForm.name"
            class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
          />
        </div>
        <small
          v-if="newGroupForm.errors.name != null"
          class="mt-1 mr-4 text-xs font-semibold text-red-800"
          v-html="newGroupForm.errors.name"
        ></small>
      </label>
    </form>
    <template #footer>
      <div class="grid w-full grid-cols-2 gap-2">
        <SecondaryButton @click="submitNewGroup"> حفظ </SecondaryButton>
        <DangerButton @click="hideAddGroup" type="button"> الغاء </DangerButton>
      </div>
    </template>
  </Model>
  <Model :show="showShift" :hide="hideShift">
    <template #title>
      {{ editId ? "تعديل الوردية" : "انشاء وردية" }}
    </template>
    <form class="p-6">
      <label class="block w-full mb-4">
        <span class="block mb-1 mr-4 text-sm font-semibold">اسم الوردية</span>
        <div class="flex items-center px-4 bg-blue-100 rounded-md">
          <input
            type="text"
            v-model="newRosyForm.name"
            @input="newRosyForm.errors.name = null"
            class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
          />
        </div>
        <small
          v-show="newRosyForm.errors.name"
          class="mt-1 text-xs font-semibold text-red-800"
          v-html="newRosyForm.errors.name"
        ></small>
      </label>
      <div class="flex items-center justify-between mb-4">
        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">وقت الدخول</span>
          <div class="flex items-center px-4 bg-blue-100 rounded-md">
            <input
              type="time"
              v-model="newRosyForm.primary_enter"
              @input="newRosyForm.errors.primary_enter = null"
              class="w-full pr-1 text-sm bg-transparent border-0 focus:ring-0 focus:border-0"
            />
          </div>
          <small
            v-show="newRosyForm.errors.primary_enter"
            class="mt-1 text-xs font-semibold text-red-800"
            v-html="newRosyForm.errors.primary_enter"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">وقت الخروج</span>
          <div class="flex items-center px-4 bg-blue-100 rounded-md">
            <input
              :min="newRosyForm.primary_enter"
              type="time"
              v-model="newRosyForm.primary_exit"
              @input="newRosyForm.errors.primary_exit = null"
              class="w-full pr-1 text-sm bg-transparent border-0 focus:ring-0 focus:outline-0"
            />
          </div>
          <small
            v-show="newRosyForm.errors.primary_exit"
            class="mt-1 text-xs font-semibold text-red-800"
            v-html="newRosyForm.errors.primary_exit"
          ></small>
        </label>
      </div>
      <div class="flex items-center justify-between">
        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"
            >احتساب الدخول</span
          >
          <div class="flex items-center px-4 bg-blue-100 rounded-md">
            <input
              :max="newRosyForm.primary_exit"
              :min="newRosyForm.primary_enter"
              type="time"
              v-model="newRosyForm.secondary_enter"
              @input="newRosyForm.errors.secondary_enter = null"
              class="w-full pr-1 text-sm bg-transparent border-0 focus:ring-0 focus:border-0"
            />
          </div>
          <small
            v-show="newRosyForm.errors.secondary_enter"
            class="mt-1 text-xs font-semibold text-red-800"
            v-html="newRosyForm.errors.secondary_enter"
          ></small>
        </label>
        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"
            >احتساب الخروج</span
          >
          <div class="flex items-center px-4 bg-blue-100 rounded-md">
            <input
              :max="newRosyForm.primary_exit"
              :min="newRosyForm.primary_enter"
              type="time"
              v-model="newRosyForm.secondary_exit"
              @input="newRosyForm.errors.secondary_exit = null"
              class="w-full pr-1 text-sm bg-transparent border-0 focus:ring-0 focus:outline-0"
            />
          </div>
          <small
            v-show="newRosyForm.errors.secondary_exit"
            class="mt-1 text-xs font-semibold text-red-800"
            v-html="newRosyForm.errors.secondary_exit"
          ></small>
        </label>
      </div>
    </form>
    <template #footer>
      <div class="grid w-full grid-cols-2 gap-2">
        <SecondaryButton @click="submitNewTime"> حفظ </SecondaryButton>
        <DangerButton @click="hideShift" type="reset"> الغاء </DangerButton>
      </div>
    </template>
  </Model>
  <TableCard>
    <template #header>
      <p class="text-xl font-semibold">مجموعات الدوام</p>
      <div class="grid grid-cols-3 gap-2">
        <secondary-button @click="showFilter = true"> فلتر </secondary-button>
        <danger-button :loading="loadingClearFilter" @click="clearFilter">
          تصفية الفلتر
        </danger-button>
        <BlueButton @click="showAddGroup = true">
          <div class="flex items-center justify-center px-2">
            اضافة مجموعة جديدة
          </div>
        </BlueButton>
      </div>
    </template>
    <template #table_header>
      <th>الورديات</th>
      <th class="py-2">اسم المجموعة</th>
      <th>رقم المجموعة</th>
      <th>الجزاءات</th>
      <th>الخيارات</th>
    </template>
    <template #table_body>
      <tr
        class="py-2 text-center border-b-2 h-14"
        v-for="item in groups"
        :key="item.id"
      >
        <td
          @click="getGroupDays(item.id)"
          class="font-semibold text-blue-500 underline cursor-pointer"
        >
          عرض
        </td>
        <td>{{ item.name }}</td>
        <td>{{ item.id }}</td>
        <td
          class="underline cursor-pointer"
          @click="item.sanctions_count ? showSanction(item.id) : () => {}"
          v-html="item.sanctions_count"
        ></td>
        <td class="flex items-center justify-evenly h-14">
          <Link
            class="font-semibold text-red-500 underline"
            :href="`/delete-group/${item.id}`"
            >حذف</Link
          >
          <div
            @click="
              showAddGroup = true;
              newGroupForm.name = item.name;
              editId = item.id;
            "
            class="mx-1 my-auto no-underline cursor-pointer hover:underline"
          >
            تعديل
          </div>
        </td>
      </tr>
    </template>

    <template v-if="section == 'create-new-rosy'" #left_side>
      <div class="flex items-center justify-between px-4 border-b">
        <div class="flex items-center px-2">
          <Icon
            @click="section = 'showGroup'"
            icon="carbon:arrow-right"
            class="ml-2 text-gray-900 cursor-pointer"
          />
          <p class="py-2 text-sky-500">إضافة وردية دوام</p>
        </div>
        <div class="flex items-center justify-end">
          <BlueButton
            v-if="newDayForm.day"
            @click="showShift = true"
            class="px-4 my-4"
          >
            اضافة وردية
          </BlueButton>
        </div>
      </div>
      <form class="p-6">
        <label class="block w-full mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">اليوم</span>
          <div class="flex items-center px-4 bg-blue-100 rounded-md">
            <select
              v-model="newDayForm.day"
              class="w-full px-4 pr-1 text-sm text-center bg-transparent border-0 focus:ring-0"
            >
              <option value="السبت">السبت</option>
              <option value="الاحد">الاحد</option>
              <option value="الاثنين">الاثنين</option>
              <option value="الثلاثاء">الثلاثاء</option>
              <option value="الاربعاء">الاربعاء</option>
              <option value="الخميس">الخميس</option>
              <option value="الجمعه">الجمعه</option>
            </select>
          </div>
          <small
            v-if="newDayForm.errors.day != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="newDayForm.errors.day"
          ></small>
        </label>

        <div
          v-for="(item, ind) in newDayForm.periods"
          :key="ind"
          class="grid w-full grid-cols-3 gap-2"
        >
          <p class="px-2" v-if="item.name">{{ item.name }}</p>
          <label v-if="item.primary_enter" class="block w-full mb-4">
            <span class="block mb-1 mr-4 text-sm font-semibold"
              >وقت الدخول</span
            >
            <div class="flex items-center px-4 bg-blue-100 rounded-md">
              <input
                type="time"
                v-model="item.primary_enter"
                disabled
                class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
              />
            </div>
            <small
              v-if="newDayForm.errors.periods?.[ind]?.primary_enter"
              class="mt-1 mr-4 text-xs font-semibold text-red-800"
              v-html="newDayForm.errors.periods?.[ind].primary_enter"
            ></small>
          </label>
          <label v-if="item.primary_exit" class="block w-full mb-4">
            <span class="block mb-1 mr-4 text-sm font-semibold"
              >وقت الخروج</span
            >
            <div class="flex items-center px-4 bg-blue-100 rounded-md">
              <input
                type="time"
                :value="item.primary_exit"
                disabled
                class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
              />
            </div>
            <small
              v-if="newDayForm.errors.periods?.[ind]?.primary_exit"
              class="mt-1 mr-4 text-xs font-semibold text-red-800"
              v-html="newDayForm.errors.periods?.[ind].primary_exit"
            ></small>
          </label>
          <p></p>
          <label v-if="item.secondary_enter" class="block w-full mb-4">
            <span class="block mb-1 mr-4 text-sm font-semibold"
              >احتساب الدخول</span
            >
            <div class="flex items-center px-4 bg-blue-100 rounded-md">
              <input
                type="time"
                :value="item.secondary_enter"
                :min="item.primary_enter"
                disabled
                class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
              />
            </div>
            <small
              v-if="newDayForm.errors.periods?.[ind]?.secondary_enter"
              class="mt-1 mr-4 text-xs font-semibold text-red-800"
              v-html="newDayForm.errors.periods?.[ind].secondary_enter"
            ></small>
          </label>
          <label v-if="item.secondary_exit" class="block w-full mb-4">
            <span class="block mb-1 mr-4 text-sm font-semibold"
              >احتساب الخروج</span
            >
            <div class="flex items-center px-4 bg-blue-100 rounded-md">
              <input
                type="text"
                :value="item.secondary_exit"
                :min="item.primary_exit"
                disabled
                class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
              />
            </div>
            <small
              v-if="newDayForm.errors.periods?.[ind]?.secondary_exit"
              class="mt-1 mr-4 text-xs font-semibold text-red-800"
              v-html="newDayForm.errors.periods?.[ind].secondary_exit"
            ></small>
          </label>
        </div>
        <div class="grid w-full grid-cols-2 gap-2">
          <SecondaryButton
            @click="submitNewDay()"
            type="button"
            :loading="newDayForm.processing"
            v-show="newDayForm.periods.length > 0"
          >
            حفظ
          </SecondaryButton>
          <DangerButton
            @click="
              section = 'showGroup';
              newDayForm.reset();
            "
            type="reset"
          >
            الغاء
          </DangerButton>
        </div>
      </form>
    </template>
    <template v-if="section == 'edit-rosy-day-form'" #left_side>
      <div class="flex items-center px-4 border-b">
        <Icon
          @click="section = 'showGroup'"
          icon="carbon:arrow-right"
          class="ml-2 text-gray-900 cursor-pointer"
        />
        <p class="py-2 text-sky-500">تعديل وردية دوام</p>
      </div>
      <form class="p-6">
        <label class="block w-full mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">اليوم</span>
          <div class="flex items-center px-4 bg-blue-100 rounded-md">
            <select
              v-model="editRosyDayForm.day"
              class="w-full px-4 pr-1 text-sm text-center bg-transparent border-0 focus:ring-0"
            >
              <option value="السبت">السبت</option>
              <option value="الاحد">الاحد</option>
              <option value="الاثنين">الاثنين</option>
              <option value="الثلاثاء">الثلاثاء</option>
              <option value="الأربعاء">الأربعاء</option>
              <option value="الخميس">الخميس</option>
              <option value="الجمعه">الجمعه</option>
            </select>
          </div>
          <small
            v-if="editRosyDayForm.errors.day != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="editRosyDayForm.errors.day"
          ></small>
        </label>

        <div class="grid w-full grid-cols-3 gap-2">
          <label v-if="editRosyDayForm.name" class="block w-full mb-4">
            <span class="block mb-1 mr-4 text-sm font-semibold">الاسم</span>
            <div class="flex items-center px-4 bg-blue-100 rounded-md">
              <input
                type="text"
                v-model="editRosyDayForm.name"
                class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
              />
            </div>
            <small
              v-show="editRosyDayForm.errors.name"
              class="mt-1 mr-4 text-xs font-semibold text-red-800"
              v-html="editRosyDayForm.errors.name"
            ></small>
          </label>
          <label v-if="editRosyDayForm.primary_enter" class="block w-full mb-4">
            <span class="block mb-1 mr-4 text-sm font-semibold"
              >وقت الدخول</span
            >
            <div class="flex items-center px-4 bg-blue-100 rounded-md">
              <input
                type="time"
                v-model="editRosyDayForm.primary_enter"
                class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
              />
            </div>
            <small
              v-show="editRosyDayForm.errors.day"
              class="mt-1 mr-4 text-xs font-semibold text-red-800"
              v-html="editRosyDayForm.errors.day"
            ></small>
          </label>
          <label v-if="editRosyDayForm.primary_exit" class="block w-full mb-4">
            <span class="block mb-1 mr-4 text-sm font-semibold"
              >وقت الخروج</span
            >
            <div class="flex items-center px-4 bg-blue-100 rounded-md">
              <input
                type="time"
                v-model="editRosyDayForm.primary_exit"
                class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
              />
            </div>
            <small
              v-show="editRosyDayForm.errors.day"
              class="mt-1 mr-4 text-xs font-semibold text-red-800"
              v-html="editRosyDayForm.errors.day"
            ></small>
          </label>
          <p></p>
          <label
            v-if="editRosyDayForm.secondary_enter"
            class="block w-full mb-4"
          >
            <span class="block mb-1 mr-4 text-sm font-semibold"
              >احتساب الدخول</span
            >
            <div class="flex items-center px-4 bg-blue-100 rounded-md">
              <input
                type="time"
                v-model="editRosyDayForm.secondary_enter"
                :min="editRosyDayForm.primary_enter"
                class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
              />
            </div>
            <small
              v-show="editRosyDayForm.errors.day"
              class="mt-1 mr-4 text-xs font-semibold text-red-800"
              v-html="editRosyDayForm.errors.day"
            ></small>
          </label>
          <label
            v-if="editRosyDayForm.secondary_exit"
            class="block w-full mb-4"
          >
            <span class="block mb-1 mr-4 text-sm font-semibold"
              >احتساب الخروج</span
            >
            <div class="flex items-center px-4 bg-blue-100 rounded-md">
              <input
                type="time"
                v-model="editRosyDayForm.secondary_exit"
                :min="editRosyDayForm.secondary_exit"
                class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
              />
            </div>
            <small
              v-show="editRosyDayForm.errors.day"
              class="mt-1 mr-4 text-xs font-semibold text-red-800"
              v-html="editRosyDayForm.errors.day"
            ></small>
          </label>
        </div>

        <div class="grid w-full grid-cols-2 gap-2">
          <SecondaryButton
            @click="submitEditDay()"
            type="button"
            :loading="editRosyDayForm.processing"
          >
            حفظ
          </SecondaryButton>
          <DangerButton
            @click="
              section = 'showGroup';
              editRosyDayForm.reset();
            "
            type="button"
          >
            الغاء
          </DangerButton>
        </div>
      </form>
    </template>
    <template #header v-if="section == 'showGroup'">
      <div class="flex items-baseline">
        <Icon
          @click="section = ''"
          icon="carbon:arrow-right"
          class="ml-2 text-gray-900 cursor-pointer"
        />
        <p class="text-xl font-semibold">عرض ورديات الدوام</p>
      </div>
      <div class="w-52">
        <BlueButton @click="section = 'create-new-rosy'">
          <div class="flex items-center justify-center">اضافة وردية جديدة</div>
        </BlueButton>
      </div>
    </template>
    <template #table_header v-if="section == 'showGroup'">
      <th>اليوم</th>
      <th>الاسم</th>
      <th>وقت الدخول</th>
      <th>وقت الخروج</th>
      <th>احتساب الدخول</th>
      <th>احتساب الخروج</th>
      <th>الخيارات</th>
    </template>
    <template #table_body v-if="section == 'showGroup'">
      <tr
        v-if="!groupDays.length"
        class="flex items-center justify-center w-full text-center"
      >
        <Loading v-if="groupDaysLoading" />
        <span v-else> لا يوجد ايام</span>
      </tr>
      <tr
        class="py-2 text-center border-b-2 h-14"
        v-for="item in groupDays"
        :key="item.id"
      >
        <td>{{ item.day }}</td>
        <td>{{ item.name }}</td>
        <td>{{ item.primary_enter }}</td>
        <td v-html="item.primary_exit"></td>
        <td v-html="item.secondary_enter"></td>
        <td v-html="item.secondary_exit"></td>
        <td class="flex items-center justify-evenly h-14">
          <div
            class="font-semibold text-red-500 underline cursor-pointer"
            @click="destroyGroupDay(item.id)"
          >
            حذف
          </div>
          <div
            @click="editGroupDay(item.id)"
            class="mx-1 my-auto underline cursor-pointer"
          >
            تعديل
          </div>
        </td>
      </tr>
    </template>

    <!-- start for sanction -->
    <template #header v-if="section == 'showSanction'">
      <div class="flex items-baseline">
        <Icon
          @click="section = ''"
          icon="carbon:arrow-right"
          class="ml-2 text-gray-900 cursor-pointer"
        />
        <p class="text-xl font-semibold">الجزاءات</p>
      </div>
    </template>
    <template #table_header v-if="section == 'showSanction'">
      <th>الاسم</th>
      <th class="h-10">القيمة</th>
      <th>اسم الموظف</th>
      <th>الخيارات</th>
    </template>
    <template #table_body v-if="section == 'showSanction'">
      <tr
        v-if="!sanctions.length"
        class="flex items-center justify-center w-full text-center"
      >
        <Loading v-if="sanctionLoading" />
        <span v-else> لا يوجد جزاءات</span>
      </tr>
      <tr
        class="py-1 text-center border-b-2"
        :style="item.isDone ? 'background-color:#60f4608f' : ''"
        :class="!item.isDone ? 'hover:bg-slate-200' : ''"
        v-for="item in sanctions"
        :key="item.id"
      >
        <td>{{ item.name }}</td>
        <td>{{ item.value }}</td>
        <td>{{ item.employee_name }}</td>
        <td class="flex items-center h-8 justify-evenly">
          <div
            class="font-semibold text-red-500 underline cursor-pointer"
            @click="cancelSanction(item.id)"
            v-if="!item.isDone"
          >
            انهاء الجزاء
          </div>
        </td>
      </tr>
    </template>
    <!-- end  for sanction -->
  </TableCard>
</template>
<script>
import BlueButton from "@/Components/Form/Buttons/BlueButton.vue";
import DropDownOption from "@/Components/Form/DropDown/DropDownOption.vue";
import DropdownList from "@/Components/Form/DropDown/DropdownList.vue";
import Loading from "@/Components/Form/Loading.vue";
import TableCard from "@/Components/Layout/Card/TableCard.vue";
import { useForm, Link, router } from "@inertiajs/vue3";
import axios from "axios";
import { Icon } from "@iconify/vue";
import Model from "@/Components/Models/Model.vue";
import DangerButton from "@/Components/Buttons/DangerButton.vue";
import SecondaryButton from "@/Components/Buttons/SecondaryButton.vue";
import Filter from "@/Components/Models/Filter/Filter.vue";

export default {
  components: {
    TableCard,
    BlueButton,
    DropdownList,
    DropDownOption,
    Link,
    Loading,
    Icon,
    Model,
    DangerButton,
    SecondaryButton,
    Filter,
  },
  props: {
    groups: Array,
    filter: Array,
  },
  data() {
    return {
      groupDays: [],
      section: "",
      createNewGroup: false,
      createNewDay: false,
      createNewDayForm: false,
      createNewRosyForm: false,
      groupDaysLoading: false,
      sanctionLoading: false,

      // filter
      showFilter: false,
      loadingClearFilter: false,
      filterKeys: ["group", "day", "from_date", "to_date"],
      filterData: this.filter,

      // Models
      showAddGroup: false,
      showShift: false,

      sanctions: [],
      newRosyForm: useForm({
        name: null,
        primary_enter: null,
        primary_exit: null,
        secondary_enter: null,
        secondary_exit: null,
      }),
      editRosyDayForm: useForm({
        id: null,
        name: null,
        day: null,
        primary_enter: null,
        primary_exit: null,
        secondary_enter: null,
        secondary_exit: null,
      }),
      days: ["sut", "sun", "mon"],
      newGroupForm: useForm({
        name: "",
      }),
      newDayForm: useForm({
        day: "",
        periods: [],
      }),
      editId: null,
      groupId: null,
      editGroupDayForm: false,
    };
  },
  methods: {
    hideFilter() {
      this.showFilter = false;
    },
    filterSuccess() {
      this.toast("", "تم فلترة المجموعة بنجاح");
      this.hideFilter();
    },
    clearFilter() {
      this.loadingClearFilter = true;
      router.get(
        "shifts",
        {},
        {
          onSuccess: () => {
            this.toast("", "تم تصفية فلتر المجموعة بنجاح");
            this.loadingClearFilter = false;
          },
        }
      );
    },
    hideAddGroup() {
      this.showAddGroup = false;
      this.editId = null;
      this.newGroupForm.reset();
    },
    hideShift() {
      this.showShift = false;
      this.newRosyForm.reset();
    },
    cancelSanction(id) {
      axios.get("/close-sanction/" + id).then((res) => {
        this.toast("", "تم انها الجزاء بنجاح");
        this.showSanction(this.groupId);
      });
    },
    showSanction(id) {
      this.groupId = id;
      this.section = "showSanction";
      this.sanctionLoading = true;
      axios
        .get("/get-sanction/" + id) // id is group
        .then((res) => {
          this.sanctionLoading = false;
          this.sanctions = res.data;
        })
        .catch((er) => console.log(er));
    },
    getGroupDays(id) {
      this.section = "showGroup";
      this.groupDaysLoading = true;
      this.groupId = id;
      axios
        .get("/get-group-days/" + id)
        .then((r) => {
          this.groupDays = r.data;
          this.groupDaysLoading = false;
        })
        .catch((er) => {
          this.groupDaysLoading = true;
          console.log(er);
        });
    },
    submitNewDay() {
      this.newDayForm.post("/add-new-day/" + this.groupId, {
        onSuccess: () => {
          this.getGroupDays(this.groupId);
          this.toast("", "تمت اظافة يوم دوام جديد بنجاح");
          this.newDayForm.reset();
        },
        onError: (e) => {
          console.log(e);
          if (e.message) {
            this.toast("", e.message, "error");
          }
        },
      });
    },
    submitNewGroup() {
      if (this.editId == null)
        this.newGroupForm.post("/store-new-group", {
          onSuccess: () => {
            this.createNewGroup = false;
            this.$emit("show");
            this.toast("", "تمت اظافة مجموعة جديدة بنجاح");
          },
        });
      else
        this.newGroupForm.post("/edit-group/" + this.editId, {
          onSuccess: () => {
            this.createNewGroup = false;
            this.$emit("show");
            this.toast("", "تم تعديل مجموعة جديدة بنجاح");
          },
        });
    },
    submitEditDay() {
      let primary_enter = this.time2object(this.editRosyDayForm.primary_enter);
      let primary_exit = this.time2object(this.editRosyDayForm.primary_exit);
      let secondary_enter = this.time2object(
        this.editRosyDayForm.secondary_enter
      );
      let secondary_exit = this.time2object(
        this.editRosyDayForm.secondary_exit
      );

      if (this.editRosyDayForm.primary_enter == null) {
        this.editRosyDayForm.errors.primary_enter =
          "لا يمكن ان يكون الحقل فارغ";
      }

      if (this.editRosyDayForm.secondary_enter == null) {
        this.editRosyDayForm.errors.secondary_enter =
          "لا يمكن ان يكون الحقل فارغ";
      }

      if (this.editRosyDayForm.primary_exit == null) {
        this.editRosyDayForm.errors.primary_exit = "لا يمكن ان يكون الحقل فارغ";
      }

      if (this.editRosyDayForm.secondary_exit == null) {
        this.editRosyDayForm.errors.secondary_exit =
          "لا يمكن ان يكون الحقل فارغ";
      }

      //   if (primary_enter?.getHours() <= secondary_enter?.getHours()) {
      //     if (primary_enter?.getMinutes() <= secondary_enter?.getMinutes())
      //       this.editRosyDayForm.errors.primary_enter =
      //         "يجب ان يكون الدخول فبل الاحتساب";
      //     console.log("5");
      //     return;
      //   }
      //   if (primary_exit.getHours() >= secondary_exit.getHours()) {
      //     if (primary_exit.getMinutes() >= secondary_exit.getMinutes())
      //       this.editRosyDayForm.errors.primary_exit =
      //         "يجب ان يكون الخروج قبل الاحتساب";
      //     console.log("6");
      //     return;
      //   }

      this.editRosyDayForm.post("/edit-group-day", {
        onSuccess: () => {
          this.getGroupDays(this.groupId);
          this.toast("", "تم تعديل يوم دوام جديد بنجاح");
        },
      });
    },
    editGroupDay(id) {
      this.editId = id;
      let data = this.groupDays.find((v) => v.id == id);
      this.editRosyDayForm.day = data.day;
      this.editRosyDayForm.id = data.id;
      this.editRosyDayForm.name = data.name;
      // this.editRosyDayForm.primary_enter = data.primary_enter;
      this.editRosyDayForm.primary_enter = this.convertTimeTo24H(
        data.primary_enter
      );
      this.editRosyDayForm.primary_exit = this.convertTimeTo24H(
        data.primary_exit
      );
      this.editRosyDayForm.secondary_enter = this.convertTimeTo24H(
        data.secondary_enter
      );
      this.editRosyDayForm.secondary_exit = this.convertTimeTo24H(
        data.secondary_exit
      );
      this.section = "edit-rosy-day-form";
    },
    convertTimeTo24H(time) {
      // convertTimeTo24H
      console.log(time);
      let hours = parseInt(time.split(":")[0]);
      let minutes = parseInt(time.split(":")[1]);
      let ampm = time.split(" ")[1];
      if (ampm == "م" && hours < 12) hours = hours + 12;
      if (ampm == "ص" && hours == 12) hours = hours - 12;
      let sHours = hours.toString();
      let sMinutes = minutes.toString();
      if (hours < 10) sHours = "0" + sHours;
      if (minutes < 10) sMinutes = "0" + sMinutes;
      return sHours + ":" + sMinutes;
    },
    destroyGroupDay(id) {
      router.delete(`/delete-group-day/${id}`, {
        onSuccess: () => {
          this.toast("", "تم حذف الوردية بنجاح");
          this.getGroupDays(this.groupId);
        },
      });
    },
    submitNewTime(e) {
      let primary_enter = this.time2object(this.newRosyForm.primary_enter);
      let primary_exit = this.time2object(this.newRosyForm.primary_exit);
      let secondary_enter = this.time2object(this.newRosyForm.secondary_enter);
      let secondary_exit = this.time2object(this.newRosyForm.secondary_exit);
      console.log("new");
      if (this.newRosyForm.name == null) {
        this.newRosyForm.errors.name = "لا يمكن ان يكون الحقل فارغ";
        return;
      }

      if (this.newRosyForm.primary_enter == null) {
        this.newRosyForm.errors.primary_enter = "لا يمكن ان يكون الحقل فارغ";
        return;
      }

      if (this.newRosyForm.secondary_enter == null) {
        this.newRosyForm.errors.secondary_enter = "لا يمكن ان يكون الحقل فارغ";
        return;
      }

      if (this.newRosyForm.primary_exit == null) {
        this.newRosyForm.errors.primary_exit = "لا يمكن ان يكون الحقل فارغ";
        return;
      }

      if (this.newRosyForm.secondary_exit == null) {
        this.newRosyForm.errors.secondary_exit = "لا يمكن ان يكون الحقل فارغ";
        return;
      }

      //   if (primary_enter.getHours() >= secondary_enter.getHours()) {
      //     if (primary_enter.getMinutes() >= secondary_enter.getMinutes())
      //       this.newRosyForm.errors.primary_enter =
      //         "يجب ان يكون الدخول فبل الاحتساب";
      //     return;
      //   }
      //   if (primary_exit.getHours() >= secondary_exit.getHours()) {
      //     if (primary_exit.getMinutes() >= secondary_exit.getMinutes())
      //       this.newRosyForm.errors.primary_exit =
      //         "يجب ان يكون الخروج قبل الاحتساب";
      //     return;
      //   }

      this.newDayForm.periods.push(this.newRosyForm.data());
      this.newRosyForm.reset();
      this.hideShift();
    },
    time2object(time) {
      if (time == null) return time;
      time = time.split(":");
      return new Date(2000, 1, 1, parseInt(time[0]), parseInt(time[1]));
    },
  },
};
</script>
