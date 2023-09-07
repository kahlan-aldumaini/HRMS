<template>
  <form @submit.prevent="submit" class="w-full">
    <FormSection v-if="selectedSection == 1" label="البيانات الشخصية">
      <div class="grid w-full grid-cols-4 gap-2">
        <label class="block w-full mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">الفرع</span>
          <div class="px-2 border rounded-md">
            <DropdownList classes="bg-white border-2 border-gray-500">
              <template #button>
                <div class="px-1">{{ form.bransh }}</div>
              </template>
              <template #items>
                <DropDownOption
                  class="hover:bg-blue-500"
                  v-for="item in branshes"
                  :select="(e) => getManagment(item.id)"
                  :key="item.id"
                >
                  {{ item.name }}
                </DropDownOption>
              </template>
            </DropdownList>
          </div>
          <small
            v-if="form.errors.bransh != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.bransh"
          ></small>
        </label>

        <label class="block w-full mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">الادارة</span>
          <div class="px-2 border rounded-md">
            <DropdownList classes="bg-white border-2 border-gray-500">
              <template #button>
                <div class="px-1">{{ form.managment }}</div>
              </template>
              <template #items>
                <DropDownOption
                  class="hover:bg-blue-500"
                  v-for="item in managment"
                  :key="item.id"
                  :select="(e) => getDepartment(item.id)"
                >
                  {{ item.name }}
                </DropDownOption>
              </template>
            </DropdownList>
          </div>
          <small
            v-if="form.errors.managment != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.managment"
          ></small>
        </label>

        <label class="block w-full mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">القسم</span>
          <div class="px-2 border rounded-md">
            <DropdownList classes="bg-white border-2 border-gray-500">
              <template #button>
                <div class="px-1">{{ form.department }}</div>
              </template>
              <template #items>
                <DropDownOption
                  class="hover:bg-blue-500"
                  v-for="item in department"
                  :key="item.id"
                  :select="(e) => getUnit(item.id)"
                >
                  {{ item.name }}
                </DropDownOption>
              </template>
            </DropdownList>
          </div>
          <small
            v-if="form.errors.department != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.department"
          ></small>
        </label>

        <label class="block w-full mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">الوحدة</span>
          <div class="px-2 border rounded-md">
            <DropdownList classes="bg-white border-2 border-gray-500">
              <template #button>
                <div class="px-1">{{ getUnitName(form.unit) }}</div>
              </template>
              <template #items>
                <DropDownOption
                  class="hover:bg-blue-500"
                  v-for="item in units"
                  :key="item.id"
                  :select="(e) => (form.unit = item.id)"
                >
                  {{ item.name }}
                </DropDownOption>
              </template>
            </DropdownList>
          </div>
          <small
            v-if="form.errors.unit != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.unit"
          ></small>
        </label>
        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">اسم الموظف</span>
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="text"
              v-model="form.name"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.name != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.name"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">رقم الموظف</span>
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="text"
              v-model="form.employee_number"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.employee_number != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.employee_number"
          ></small>
        </label>

        <div class="grid w-full grid-cols-2 gap-2 px-2 mb-4">
          <label class="block w-full mb-4">
            <span class="block mb-1 mr-4 text-sm font-semibold">الجنس</span>
            <div class="pl-2 border rounded-md">
              <DropdownList classes="bg-white border-2 border-gray-500">
                <template #button>
                  <div class="px-1">{{ form.sex }}</div>
                </template>
                <template #items>
                  <DropDownOption
                    class="hover:bg-blue-500"
                    :select="(e) => (form.sex = 'ذكر')"
                  >
                    ذكر
                  </DropDownOption>
                  <DropDownOption
                    class="hover:bg-blue-500"
                    :select="(e) => (form.sex = 'انثى')"
                  >
                    انثى
                  </DropDownOption>
                </template>
              </DropdownList>
            </div>
            <small
              v-if="form.errors.sex != null"
              class="mt-1 mr-4 text-xs font-semibold text-red-800"
              v-html="form.errors.sex"
            ></small>
          </label>
          <label class="block w-full px-2 mb-4">
            <span class="block mb-1 mr-4 text-sm font-semibold">الجنسية</span>
            <div
              class="flex items-center bg-white border-2 border-gray-500 rounded-md"
            >
              <input
                dir="rtl"
                type="text"
                v-model="form.nationality"
                class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
              />
            </div>
            <small
              v-if="form.errors.nationality != null"
              class="mt-1 mr-4 text-xs font-semibold text-red-800"
              v-html="form.errors.nationality"
            ></small>
          </label>
        </div>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"
            >تاريخ الميلاد</span
          >
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="date"
              v-model="form.birth_date"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.birth_date != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.birth_date"
          ></small>
        </label>

        <label class="block w-full mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"
            >الحالة الاجتماعية</span
          >
          <div class="px-2 border rounded-md">
            <DropdownList classes="bg-white border-2 border-gray-500">
              <template #button>
                <div class="px-1">{{ form.marital_status }}</div>
              </template>
              <template #items>
                <DropDownOption
                  class="hover:bg-blue-500"
                  :select="(e) => (form.marital_status = 'عازب')"
                >
                  عازب
                </DropDownOption>
                <DropDownOption
                  class="hover:bg-blue-500"
                  :select="(e) => (form.marital_status = 'متزوج')"
                >
                  متزوج
                </DropDownOption>
              </template>
            </DropdownList>
          </div>
          <small
            v-if="form.errors.marital_status != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.marital_status"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">رقم التلفون</span>
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="tel"
              v-model="form.phone_number"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.phone_number != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.phone_number"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"> الايميل</span>
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="email"
              v-model="form.email"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.email != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.email"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">محل الاقامة</span>
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="text"
              v-model="form.place_of_residence"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.place_of_residence != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.place_of_residence"
          ></small>
        </label>
      </div>
      <template #footer>
        <div class="flex items-center justify-end">
          <div class="flex items-center justify-center w-1/6">
            <BlueButton type="submit"> التالي </BlueButton>
          </div>
        </div>
      </template>
    </FormSection>

    <FormSection v-if="selectedSection == 2" label="بيانات الهوية">
      <div class="grid w-full grid-cols-4 gap-2">
        <label class="block w-full mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">نوع الهوية</span>
          <div class="px-2 border rounded-md">
            <DropdownList classes="bg-white border-2 border-gray-500">
              <template #button>
                <div class="px-1">{{ form.type_of_identity }}</div>
              </template>
              <template #items>
                <DropDownOption
                  class="hover:bg-blue-500"
                  :select="(e) => (form.type_of_identity = 'بطاقة')"
                >
                  بطاقة
                </DropDownOption>
                <DropDownOption
                  class="hover:bg-blue-500"
                  :select="(e) => (form.type_of_identity = 'جواز سفر')"
                >
                  جواز سفر
                </DropDownOption>
              </template>
            </DropdownList>
          </div>
          <small
            v-if="form.errors.type_of_identity != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.type_of_identity"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">رقم الهوية</span>
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="text"
              v-model="form.identity_number"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.identity_number != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.identity_number"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"
            >مكان اصدار الهوية</span
          >
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="text"
              v-model="form.identity_place"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.identity_place != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.identity_place"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"
            >تاريخ اصدار الهوية</span
          >
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="date"
              v-model="form.identity_export_date"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.identity_export_date != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.identity_export_date"
          ></small>
        </label>
      </div>
      <template #footer>
        <div class="flex items-center justify-end">
          <div class="flex w-1/3">
            <BlueButton type="submit"> التالي </BlueButton>
            <button
              @click="selectedSection = 1"
              type="button"
              class="w-full py-2 mx-2 text-sm font-semibold text-white rounded-full bg-slate-500"
            >
              السابق
            </button>
          </div>
        </div>
      </template>
    </FormSection>

    <FormSection v-if="selectedSection == 3" label="بيانات المؤهل">
      <div class="grid w-full grid-cols-4 gap-2">
        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"
            >المؤهل العلمي</span
          >
          <div class="px-2 border rounded-md">
            <DropdownList classes="bg-white border-2 border-gray-500">
              <template #button>
                <div class="px-1">{{ form.qualification }}</div>
              </template>
              <template #items>
                <DropDownOption
                  v-for="item in qualifications"
                  :key="item.id"
                  class="hover:bg-blue-500"
                  :select="
                    (e) => {
                      form.qualification = item.name;
                      form.qualification_type = null;
                    }
                  "
                >
                  {{ item.name }}
                </DropDownOption>
              </template>
            </DropdownList>
          </div>
          <small
            v-if="form.errors.qualification != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.qualification"
          ></small>
        </label>

        <label class="block w-full mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">نوع المؤهل</span>
          <div class="px-2 border rounded-md">
            <DropdownList classes="bg-white border-2 border-gray-500">
              <template #button>
                <div class="px-1">{{ form.qualification_type }}</div>
              </template>
              <template #items>
                <DropDownOption
                  v-for="item in qualifications.find(
                    (v) => v.name == form.qualification
                  )?.types"
                  :key="item.id"
                  class="hover:bg-blue-500"
                  :select="(e) => (form.qualification_type = item.name)"
                >
                  {{ item.name }}
                </DropDownOption>
              </template>
            </DropdownList>
          </div>
          <small
            v-if="form.errors.type_of_identity != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.type_of_identity"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"
            >المؤهل من تاريخ</span
          >
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="date"
              v-model="form.qualification_from_date"
              :max="form.qualification_to_date"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.qualification_from_date != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.qualification_from_date"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"
            >المؤهل الى تاريخ</span
          >
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="date"
              :min="form.qualification_from_date"
              v-model="form.qualification_to_date"
              :max="getToday()"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.qualification_to_date != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.qualification_to_date"
          ></small>
        </label>
      </div>
      <template #footer>
        <div class="flex items-center justify-end">
          <div class="flex w-1/3">
            <BlueButton type="submit"> التالي </BlueButton>
            <button
              @click="selectedSection = 2"
              type="button"
              class="w-full py-2 mx-2 text-sm font-semibold text-white rounded-full bg-slate-500"
            >
              السابق
            </button>
          </div>
        </div>
      </template>
    </FormSection>

    <FormSection v-if="selectedSection == 4" label="البيانات الوظيفيه">
      <div class="grid w-full grid-cols-4 gap-2">
        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"
            >المسمى الوظيفي</span
          >
          <div class="px-2 border rounded-md">
            <DropdownList classes="bg-white border-2 border-gray-500">
              <template #button>
                <div class="px-1">{{ form.career_name }}</div>
              </template>
              <template #items>
                <DropDownOption
                  v-for="item in career_names"
                  :key="item.id"
                  class="hover:bg-blue-500"
                  :select="(e) => (form.career_name = item.name)"
                >
                  {{ item.name }}
                </DropDownOption>
              </template>
            </DropdownList>
          </div>
          <small
            v-if="form.errors.career_name != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.career_name"
          ></small>
        </label>

        <label class="block w-full mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"
            >الدرجة الوظيفيه</span
          >
          <div class="px-2 border rounded-md">
            <DropdownList classes="bg-white border-2 border-gray-500">
              <template #button>
                <div class="px-1">{{ form.career_degree }}</div>
              </template>
              <template #items>
                <DropDownOption
                  v-for="item in career_degrees"
                  :key="item.id"
                  class="hover:bg-blue-500"
                  :select="(e) => (form.career_degree = item.name)"
                >
                  {{ item.name }}
                </DropDownOption>
              </template>
            </DropdownList>
          </div>
          <small
            v-if="form.errors.career_degree != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.career_degree"
          ></small>
        </label>

        <div class="flex w-full px-2 mb-4">
          <label class="block w-full mb-4">
            <span class="block mb-1 text-sm font-semibold">الفئة الوظيفيه</span>
            <div class="pl-2 border rounded-md">
              <DropdownList classes="bg-white border-2 border-gray-500">
                <template #button>
                  <div class="px-1">{{ form.career_category }}</div>
                </template>
                <template #items>
                  <DropDownOption
                    v-for="item in career_categories"
                    :key="item.id"
                    class="hover:bg-blue-500"
                    :select="(e) => (form.career_category = item.name)"
                  >
                    {{ item.name }}
                  </DropDownOption>
                </template>
              </DropdownList>
            </div>
            <small
              v-if="form.errors.career_category != null"
              class="mt-1 mr-4 text-xs font-semibold text-red-800"
              v-html="form.errors.career_category"
            ></small>
          </label>
          <label class="block w-full mb-4">
            <span class="block mb-1 mr-4 text-sm font-semibold"
              >نوع الموظف</span
            >
            <div class="pr-2 border rounded-md">
              <DropdownList classes="bg-white border-2 border-gray-500">
                <template #button>
                  <div class="px-1">{{ form.career_type }}</div>
                </template>
                <template #items>
                  <DropDownOption
                    class="hover:bg-blue-500"
                    :select="(e) => (form.career_type = 'ثابت')"
                  >
                    ثابت
                  </DropDownOption>
                  <DropDownOption
                    class="hover:bg-blue-500"
                    :select="(e) => (form.career_type = 'متعاقد')"
                  >
                    متعاقد
                  </DropDownOption>
                </template>
              </DropdownList>
            </div>
            <small
              v-if="form.errors.career_type != null"
              class="mt-1 mr-4 text-xs font-semibold text-red-800"
              v-html="form.errors.career_type"
            ></small>
          </label>
        </div>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"
            >تاريخ التعيين</span
          >
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="date"
              v-model="form.date_of_hiring"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.date_of_hiring != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.date_of_hiring"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">رقم تصريح العمل</span>
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="number"
              v-model="form.work_permit"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.work_permit != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.work_permit"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">تصريح من</span>
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="date"
              v-model="form.permit_from"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.permit_from != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.permit_from"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">تصريح الى</span>
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="date"
              :min="form.permit_from"
              v-model="form.permit_to"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.permit_to != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.permit_to"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">سن التقاعد</span>
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="number"
              v-model="form.retirement_age"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.retirement_age != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.retirement_age"
          ></small>
        </label>
      </div>
      <template #footer>
        <div class="flex items-center justify-end">
          <div class="flex w-1/3">
            <BlueButton type="submit"> التالي </BlueButton>
            <button
              @click="selectedSection = 3"
              type="button"
              class="w-full py-2 mx-2 text-sm font-semibold text-white rounded-full bg-slate-500"
            >
              السابق
            </button>
          </div>
        </div>
      </template>
    </FormSection>

    <FormSection v-if="selectedSection == 5" label="بيانات الخدمة">
      <div class="grid w-full grid-cols-4 gap-2">
        <label class="block w-full mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">المجموعة</span>
          <div class="px-2 border rounded-md">
            <DropdownList classes="bg-white border-2 border-gray-500">
              <template #button>
                <div class="px-1">
                  {{ groups.find((v) => v.id == form.group)?.name }}
                </div>
              </template>
              <template #items>
                <DropDownOption
                  v-for="item in groups"
                  :key="item.id"
                  class="hover:bg-blue-500"
                  :select="(e) => (form.group = item.id)"
                >
                  {{ item.name }}
                </DropDownOption>
              </template>
            </DropdownList>
          </div>
          <small
            v-if="form.errors.group != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.group"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">من تاريخ</span>
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="date"
              v-model="form.group_from"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.group_from != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.group_from"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">الى تاريخ</span>
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="date"
              :min="form.group_from"
              v-model="form.group_to"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.group_to != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.group_to"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"
            >تاريخ انهاء الخدمة</span
          >
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="date"
              v-model="form.service_expirateion_date"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.service_expirateion_date != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.service_expirateion_date"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"
            >سنوات الخدمة الداخلية</span
          >
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="number"
              v-model="form.in_work_date"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.in_work_date != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.in_work_date"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"
            >سنوات الخدمة الخارجية</span
          >
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="number"
              v-model="form.out_work_date"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.out_work_date != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.out_work_date"
          ></small>
        </label>
      </div>
      <template #footer>
        <div class="flex items-center justify-end">
          <div class="flex w-1/6">
            <BlueButton type="submit"> التالي </BlueButton>
            <button
              @click="selectedSection = 4"
              type="button"
              class="w-full py-2 mx-2 text-sm font-semibold text-white rounded-full bg-slate-500"
            >
              السابق
            </button>
          </div>
        </div>
      </template>
    </FormSection>

    <FormSection v-if="selectedSection == 6" label="بيانات الراتب">
      <div class="grid w-full grid-cols-4 gap-2">
        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"
            >الراتب الاساسي</span
          >
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="number"
              v-model="form.salary_primary"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.salary_primary != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.salary_primary"
          ></small>
        </label>
        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold"
            >الراتب الشامل</span
          >
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="number"
              v-model="form.salary_all"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.salary_all != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.salary_all"
          ></small>
        </label>
        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">من</span>
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="date"
              :max="form.salary_end"
              v-model="form.salary_start"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.salary_start != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.salary_start"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">الى</span>
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="date"
              :min="form.salary_start"
              v-model="form.salary_end"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.salary_end != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.salary_end"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">اسم البنك</span>
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="text"
              v-model="form.salary_bank_name"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.salary_bank_name != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.salary_bank_name"
          ></small>
        </label>

        <label class="block w-full px-2 mb-4">
          <span class="block mb-1 mr-4 text-sm font-semibold">رقم الحساب</span>
          <div
            class="flex items-center bg-white border-2 border-gray-500 rounded-md"
          >
            <input
              dir="rtl"
              type="text"
              v-model="form.salary_account_number"
              class="pr-1 text-sm bg-transparent border-0 focus:ring-0"
            />
          </div>
          <small
            v-if="form.errors.salary_account_number != null"
            class="mt-1 mr-4 text-xs font-semibold text-red-800"
            v-html="form.errors.salary_account_number"
          ></small>
        </label>
      </div>
      <template #footer>
        <div class="flex items-center justify-end">
          <div class="flex w-1/6">
            <button
              @click="selectedSection = 4"
              type="button"
              class="w-full py-2 mx-2 text-sm font-semibold text-white rounded-full bg-slate-500"
            >
              السابق
            </button>
          </div>
        </div>
      </template>
    </FormSection>

    <div v-if="selectedSection >= 6" class="flex items-center justify-end">
      <div class="flex w-1/3">
        <BlueButton @click="form.done = true" type="submit"> حفظ </BlueButton>
        <button
          type="reset"
          class="w-full py-2 mx-2 text-sm font-semibold text-white bg-red-500 rounded-full"
        >
          الغاء
        </button>
      </div>
    </div>
  </form>
</template>
<script>
import BlueButton from "@/Components/Form/Buttons/BlueButton.vue";
import DropDownOption from "@/Components/Form/DropDown/DropDownOption.vue";
import DropdownList from "@/Components/Form/DropDown/DropdownList.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import FormSection from "@/Components/Sections/FormSection.vue";
import { router, useForm } from "@inertiajs/vue3";
import axios from "axios";

export default {
  props: {
    employee: {
      type: Object,
      default: null,
    },
  },
  data: () => ({
    branshes: [{ name: "", id: 0 }],
    managment: [],
    department: [],
    groups: [],
    units: [],
    selectedSection: 1,
    career_names: [],
    career_degrees: [],
    career_categories: [],
    form: useForm({
      id: null,
      name: null,
      nationality: null,
      unit: null,
      bransh: null,
      managment: null,
      department: null,
      phone_number: null,
      sex: null,
      birth_date: null,
      marital_status: null,
      employee_number: null,
      email: null,
      place_of_residence: null,
      type_of_identity: null,
      identity_number: null,
      identity_export_date: null,
      identity_place: null,
      qualification: null,
      qualification_type: null,
      qualification_from_date: null,
      qualification_to_date: null,
      group: null,
      group_from: null,
      group_to: null,
      career_name: null,
      career_degree: null,
      career_type: null,
      career_category: null,
      date_of_hiring: null,
      work_permit: null,
      permit_from: null,
      permit_to: null,
      retirement_age: null,
      service_expirateion_date: null,
      in_work_date: null,
      out_work_date: null,
      salary_all: null,
      salary_primary: null,
      salary_start: null,
      salary_end: null,
      salary_bank_name: null,
      salary_account_number: null,
      done: false,
    }),
    qualifications: [
      {
        id: 1,
        name: "ثانوي",
        types: [
          {
            id: 1,
            name: "ادبي",
          },
          {
            id: 2,
            name: "علمي",
          },
        ],
      },
      {
        id: 1,
        name: "جامعي",
        types: [
          {
            id: 1,
            name: "بكلريوس",
          },
          {
            id: 2,
            name: "ماجستير",
          },
          {
            id: 3,
            name: "دكتوراه",
          },
        ],
      },
    ],
  }),
  async created() {
    await this.getCareerNames();
    await this.getBransh();
    this.getGroups();
    if (this.employee != null) {
      this.form = useForm({ ...this.employee });
      await this.getManagment(
        this.branshes.filter((v) => (v.name = this.employee.bransh))[0].id
      );
      await this.getDepartment(
        this.managment.filter((v) => (v.name = this.employee.managment))[0].id
      );
      await this.getUnit(
        this.department.filter((v) => (v.name = this.employee.department))[0].id
      );
      this.form.unit = this.employee.unit;
    }
  },
  components: {
    FormInput,
    DropDownOption,
    DropdownList,
    BlueButton,
    FormSection,
  },
  methods: {
    submit() {
      this.form.post("/employee", {
        onSuccess: () => {
          if (this.selectedSection >= 6) {
            this.toast(
              "",
              `تم ${
                this.form.id != null
                  ? "تعديل الموظف بنجاح"
                  : "انشاء الموظف بنجاح"
              }`
            );
            router.get("/employees");
          } else this.selectedSection++;
        },
        onError: (e) => {
          let errorKeys = Object.keys(e);
          let keys = [];
          if (this.selectedSection == 1)
            keys = [
              "name",
              "nationality",
              "unit",
              "bransh",
              "managment",
              "department",
              "phone_number",
              "sex",
              "birth_date",
              "marital_status",
              "employee_number",
              "email",
              "place_of_residence",
            ];

          if (this.selectedSection == 2)
            keys = [
              "type_of_identity",
              "identity_number",
              "identity_export_date",
              "identity_place",
            ];

          if (this.selectedSection == 3) {
            this.getCareerNames();
            this.getCareerCategories();
            this.getCareerDegrees();
            keys = [
              "qualification",
              "qualification_type",
              "qualification_from_date",
              "qualification_to_date",
            ];
          }

          if (this.selectedSection == 4) {
            keys = [
              "career_name",
              "career_degree",
              "career_type",
              "career_category",
              "date_of_hiring",
              "work_permit",
              "permit_from",
              "permit_to",
              "retirement_age",
            ];
          }

          if (this.selectedSection == 5) {
            keys = [
              "service_expirateion_date",
              "in_work_date",
              "out_work_date",
              "group",
              "group_from",
              "group_to",
            ];
          }

          if (this.selectedSection == 6) {
            keys = [
              "salary_all",
              "salary_primary",
              "salary_start",
              "salary_end",
              "salary_bank_name",
              "salary_account_number",
            ];
          }

          if (!errorKeys.some((v) => keys.some((k) => k == v))) {
            this.selectedSection++;
          }
        },
      });
    },
    async getBransh() {
      await axios.get("/get_bransh").then((res) => (this.branshes = res.data));
    },
    async getManagment(id) {
      this.form.bransh = this.branshes.find((v) => v.id == id).name;
      this.form.managment = null;
      this.form.department = "";
      this.form.unit = "";
      await axios
        .get("/get_management/" + id)
        .then((res) => (this.managment = res.data));
    },
    async getDepartment(id) {
      this.form.managment = this.managment.find((v) => v.id == id).name;
      this.form.department = "";
      this.form.unit = "";
      await axios
        .get("/get_department/" + id)
        .then((res) => (this.department = res.data));
    },
    async getUnit(id) {
      this.form.department = this.department.find((v) => v.id == id).name;
      this.form.unit = "";
      await axios.get("/get_unit/" + id).then((res) => (this.units = res.data));
    },
    getUnitName(id) {
      return this.units.find((v) => v.id == id)?.name || "";
    },
    getToday() {
      let date = new Date();
      return date.toLocaleDateString();
    },
    getGroups() {
      axios
        .get("/get-groups")
        .then((res) => {
          console.log("groups", res.data);
          this.groups = res.data;
        })
        .catch((v) => console.log(v, "get groups"));
    },
    async getCareerNames() {
      await axios
        .get("/get-career-name")
        .then((res) => (this.career_names = res.data));
    },
    async getCareerDegrees() {
      await axios
        .get("/get-career-degrees")
        .then((res) => (this.career_degrees = res.data));
    },
    async getCareerCategories() {
      await axios
        .get("/get-career-categories")
        .then((res) => (this.career_categories = res.data));
    },
  },
};
</script>
