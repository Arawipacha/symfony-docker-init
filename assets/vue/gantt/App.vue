<template>


  {{ dateFrom }}
  <!-- <Greet /> -->
  <div id="gantt-settings">
    <div class="row">
      <div class="col">
        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label></label>
              <select class="form-control form-control-sm">
                <option value="year-month">Month / Day</option>
                <option value="day">Day / Time</option>
              </select>
            </div>
          </div>
          <div class="col-sm-4 pe-0 ps-0">
            <label>Data inizio</label>
            <div class="input-group input-group-sm mb-3">
              <select class="form-control form-control-sm " v-model="year_from"
                :style="{ color: isValidDate ? 'white' : 'red' }">
                <option v-for="y in years" :value="y">{{ y }}</option>
              </select>
              <select class="form-control form-control-sm" v-model="month_from"
                :style="{ color: isValidDate ? 'white' : 'red' }">
                <option v-for="(month, index) in months" :value="index">{{ month }}</option>
              </select>
            </div>
          </div>

          <div class="col-sm-4 pe-0 ps-0">
            <label>Data fine</label>
            <div class="input-group input-group-sm mb-3">
              <select class="form-control form-control-sm " v-model="year_to"
                :style="{ color: isValidDate ? 'white' : 'red' }">
                <option v-for="y in years" :value="y">{{ y }}</option>
              </select>
              <select class="form-control form-control-sm" v-model="month_to"
                :style="{ color: isValidDate ? 'white' : 'red' }">
                <option v-for="(month, index) in months" :value="index">{{ month }}</option>

              </select>
            </div>
          </div>

        </div>


      </div>
    </div>


  </div>

  <!-- <div id="gantt-container">

    </div>
 -->


  <div id="gantt-container" :style="{ 'grid-template-columns': `100px repeat(${dateFrom}, 1fr)` }">
    <div class="gantt-row-resource"></div>
    <div class="gantt-row-period "  v-for="item in initFirstRow">{{ item }}</div>

    <div class="gantt-row-resource" style="border: none;"></div>
    <!-- <div class="gantt-row-period">
      <div class="gantt-row-period" v-for="item in initFirstRow">{{ item }}</div>
    </div> -->
    <!-- {{initSecondRow}} -->
    
      <div class="gantt-row-period" v-for="monthday in initSecondRow">
        <!-- {{monthday.month}} -->
        <div class="gantt-row-period cell" v-for="day in monthday.day">
          {{ day }}

        </div>
      </div>

    
  </div>
  <Greet></Greet>
</template>
<script setup lang="ts">
import { computed, reactive, ref } from 'vue';


import { range } from './uitils/range';

import Greet from "./components/Greet.vue";
const year_from = ref(2020);
const year_to = ref(2020);
const month_from = ref(0);
const month_to = ref(0);

const dateFrom = computed(() => {
  if (isValidDate.value) {
    const first_month = new Date(year_from.value, month_from.value, 1);
    const last_month = new Date(year_to.value, month_to.value, 1);
    var n_months = monthDiff(first_month, last_month) + 1;
    return n_months;
  }

  return 1;

});


const initFirstRow = computed(() => {
  let names: string[] = []
  if (checkElements()) {
    const first_month = new Date(year_from.value, month_from.value, 1);
    const last_month = new Date(year_to.value, month_to.value, 1);

    var month = new Date(first_month);

    for (month; month <= last_month; month.setMonth(month.getMonth() + 1)) {
      /* var period = document.createElement("div");
      period.className = "gantt-row-period"; */
      names.push(months[month.getMonth()] + " " + month.getFullYear());
    }
    return names;
  }
  return names;
});



const initSecondRow = computed(() => {
  const month_days: { month: number, day: number[] }[] = [];
  if (checkElements()) {

    const first_month = new Date(year_from.value, month_from.value, 1);
    const last_month = new Date(year_to.value, month_to.value, 1);

    /* var resource = document.createElement("div");
    resource.className = "gantt-row-resource";
    resource.style.borderTop = "none";
    container.appendChild(resource); */

    const month = new Date(first_month);

    for (month; month <= last_month; month.setMonth(month.getMonth() + 1)) {

      /* const month_period = document.createElement("div");
      month_period.className = "gantt-row-period";
      month_period.style.border = "none";
      container.appendChild(month_period); */
      month_days.push({ month: month.getMonth(), day: [] })
      const f_om = new Date(month);
      const l_om = new Date(month.getFullYear(), month.getMonth() + 1, 0);

      var date = new Date(f_om);

      for (date; date <= l_om; date.setDate(date.getDate() + 1)) {

        /* var period = document.createElement("div");
        period.className = "gantt-row-period";
        period.style.borderTop = "none";
        period.innerHTML = date.getDate(); */
        month_days[month.getMonth()].day.push(date.getDate());
        //month_period.appendChild(period);
      }
    }
  }
  return month_days;
})



const isValidDate = computed(() => {
  if (checkElements()) {
    if ((year_from.value > year_to.value) || (year_from.value == year_to.value && month_from.value > month_to.value)) {
      return false;
    }
    return true;
  }
  return false;



})

const checkElements = () => {

  if (year_from.value != null && year_to.value != null && month_from.value != null && month_to.value != null) {
    return true;
  }
  return false;
}

const monthDiff = (d1: Date, d2: Date) => {
  var months;
  months = (d2.getFullYear() - d1.getFullYear()) * 12;
  months -= d1.getMonth();
  months += d2.getMonth();
  return months <= 0 ? 0 : months;
}

const years = ref(range(2020, 2030));
const months = reactive([
  "Gen",  // Gennaio
  "Feb",  // Febbraio
  "Mar",  // Marzo
  "Apr",  // Aprile
  "Mag",  // Maggio
  "Giu",  // Giugno
  "Lug",  // Luglio
  "Ago",  // Agosto
  "Set",  // Settembre
  "Ott",  // Ottobre
  "Nov",  // Novembre
  "Dic"   // Dicembre
]);


</script>

<style scoped>
.logo.vite:hover {
  filter: drop-shadow(0 0 2em #747bff);
}

.logo.vue:hover {
  filter: drop-shadow(0 0 2em #249b73);
}




.gantt-row-resource {
  background-color: whitesmoke;
  color: rgba(0, 0, 0, 0.726);
  border: 1px solid rgb(133, 129, 129);
  text-align: center;
}

.gantt-row-period {
  background-color: whitesmoke;
  color: rgba(0, 0, 0, 0.726);
  border: 1px solid rgb(133, 129, 129);
  text-align: center;

  display: grid;
  grid-auto-flow: column;
  grid-auto-columns: minmax(20px, 1fr);
}

.gantt-row-item {
  border: 1px dashed grey;
  padding: 10px 0 10px 0;
  position: relative;
  background-color: white;
}

.job {
  position: absolute;
  height: 10px;
  top: 5px;
  width: calc(2*100%);
  z-index: 100;
  background-color: olive;
  border-radius: 5px;
  cursor: pointer;
}

.drag-hide {
  transition: 0.01s;
  transform: translateX(-9999px);
}

#select-level {
  text-align: left;
  margin-top: 10px;
}

#gantt-settings {

  display: flex;
  align-items: center;
  column-gap: 3px;
  font-size: 10px;
  margin-bottom: 10px;
}

#gantt-container {
  display: grid;
}

.gantt-row-resource {
  background-color: whitesmoke;
  color: rgba(0, 0, 0, 0.726);
  border: 1px solid rgb(133, 129, 129);
  text-align: center;
}

.gantt-row-period {
  display: grid;
  grid-auto-flow: column;
  grid-auto-columns: minmax(20px, 1fr);
  background-color: whitesmoke;
  color: rgba(0, 0, 0, 0.726);
  border: 1px solid rgb(133, 129, 129);
  text-align: center;
}
.cell{
  width: 30px;
}
</style>
