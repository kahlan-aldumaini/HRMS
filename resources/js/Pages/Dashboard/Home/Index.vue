<template>
  <div class="grid w-full grid-cols-5 gap-4">
    <Count label="عدد الموظفين" :number="emp_count" />
    <Count label="عدد المستخدمين" :number="user_count" />
    <Count label="عدد مجموعات الدوام" :number="group_count" />
    <Count label="عدد فترات الدوام" :number="shift_count" />
    <Count label="عدد الموظفين المنهي خدمتهم" :number="end_emp_count" />
  </div>
  <div class="grid w-full grid-cols-2 gap-4 mt-5">
    <div class="flex flex-col items-center p-2 bg-white rounded-md shadow-sm">
      <div class="w-full p-4 font-sans text-2xl font-semibold">
        الاجازات والتكاليف {{ getYear() }}
      </div>
      <apexchart
        width="500"
        type="line"
        :options="vactions.options"
        :series="vactions.series"
      />
    </div>
    <div class="flex flex-col items-center p-2 bg-white rounded-md shadow-sm">
      <div class="w-full p-4 font-sans text-2xl font-semibold">
        الجزاءات في شهر {{ getMonth() }}
      </div>
      <apexchart
        width="500"
        type="line"
        :options="sanction.options"
        :series="sanction.series"
      />
    </div>
  </div>
</template>
<script>
import AppLayout from "../../../Layouts/AppLayout.vue";
import Count from "@/Components/Report/Count.vue";
export default {
  name: "Index",
  props: {
    emp_count: Number,
    user_count: Number,
    group_count: Number,
    shift_count: Number,
    end_emp_count: Number,
    vactions: Object,
    sanction: Object,
    bransh: Object,
  },
  components: { Count },
  layout: AppLayout,
  data() {
    return {
      options: {
        chart: {
          id: "vuechart-example",
        },

        xaxis: {
          categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998],
        },
      },
      series: [
        {
          name: "series-1",
          data: [30, 40, 45, 50, 49, 60, 70, 91],
        },
        {
          name: "series-2",
          data: [20, 50, 52, 15, 64, 10, 70, 91],
        },
      ],
    };
  },
  methods: {
    getYear() {
      var today = new Date();
      return today.getFullYear();
    },
    getMonth() {
      var today = new Date();
      return today.getMonth() + 1;
    },
  },
};
</script>
