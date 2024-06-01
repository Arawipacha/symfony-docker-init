<template>
  <div id="gantt" class="container-fluid dark p-0">
    <table class="table table-sm  table-dark" >
      <thead>
        <!-- <tr>
          <th :colspan="monthdays.reduce((accumulator, currentValue) => accumulator + (currentValue.fine - currentValue.ini + 1), 0)">sss</th>
        </tr> -->
        <tr>
          <th>

            <div class="  d-flex justify-content-between">
              <!-- <button type="button" class="btn btn-primary btn-sm"
                style="--bs-btn-padding-y: .20rem; --bs-btn-padding-x: .4rem; --bs-btn-font-size: .70rem;">
                Edit
              </button> -->
              <ProjectEdit v-if="project" :project="project" @on-change="handlerSaveProject" @on-create="handlerNewProject"></ProjectEdit>
              
              <ProjectList :projects="projects" @on-project="handlerChangeProject" @on-search-name="handlerSearchProject"></ProjectList>
            </div>
          </th>
          <th v-if="monthdays && !loading" v-for="m in monthdays" :colspan="(m.fine - m.ini+1)">
            <div>{{ months[m.month] }}</div>
          </th>
        </tr>
        <tr>
          <th>
            <div class="d-flex justify-content-between">
              <span>{{ project?.name }}</span>
              <TaskEdit :show="showTask" :task="task" @onChangeModal="handlerChangeModalTask" @on-change="handlerSaveTask" @on-create="handlerNewTask"></TaskEdit>
            </div>
          </th>
          <th  v-for="day in buildTableHeader" class="cell text-center">
            {{ day }}
          </th>
        </tr>
      </thead>
      <tbody v-if="!loading">
        <tr v-if="buildTableBody" v-for="item in buildTableBody">
          <td @click="handlerSelectTask(item.task)" class="cursor">
            {{ item.task.name }}
          </td>

          <td v-if="item.daysBefore > 0" v-for="_ in range(1, item.daysBefore, 1)"></td>

          <td class="event-cell" :colspan="item.days" :style="{ cursor:'pointer', 'background-color': `${item.task.color}` }" @click="handlerSelectTask(item.task)">

            {{ item.task.per }}%
          </td>

          <td v-if="item.daysAfter > 0" v-for="_ in range(1, item.daysAfter, 1)"></td>

        </tr>
      </tbody>
    </table>
  </div>
  
</template>
<script setup lang="ts">

import { computed, onMounted, reactive, ref} from 'vue';
import { range } from '../uitils/range';
import ProjectList from './../components/ProjectsList.vue'
import ProjectEdit from './../components/EditProject.vue'
import TaskEdit from './../components/EditTask.vue'
import { useGanttStore } from '../stores/gantt.store';
import { ProjectInterface } from '../interfaces/project.interface';
import { TaskInterface } from '../interfaces/task.interface';
import { Task } from '../models/task';


interface IMonth {
  month: number;
  ini: number;
  fine: number;
}


const showTask = ref(false);


const tasks= computed(()=>storeProject.getTasks)

/* const tasks = ref<TaskInterface[]>([
  { name: 'Action 1', ini: '2024/05/12', fine: '2024/05/12', color: '#4287f5', per: 80 },
  { name: 'Action 2', ini: '2024/05/12', fine: '2024/05/14', color: '#c1409b', per: 10 },
  { name: 'Action 3', ini: '2024/05/14', fine: '2024/05/17', color: '#0b9971', per: 20 },
  { name: 'Action 4 para dexcribir', ini: '2024/05/18', fine: '2024/05/22', color: '#d26a52', per: 55 },
  { name: 'Action 5', ini: '2024/05/19', fine: '2024/05/22', color: '#4287f5', per: 100 },
  { name: 'Action 6', ini: '2024/05/12', fine: '2024/05/20', color: '#0b9971', per: 32 },
  { name: 'Action 7', ini: '2024/05/20', fine: '2024/07/02', color: '#0b9971', per: 32 },
]); */

const minDate = ref<number>();
const maxDate = ref<number>();


const storeProject = useGanttStore();

const projects = computed(() => storeProject.getprojects);
const project = computed(() => storeProject.getproject);
const task = computed(() => storeProject.select_task);
const loading=computed(()=>storeProject.getLoading)


const setMinAndMaxDate = () => {
  let maxDates: number[] = [];
  let minDates: number[] = [];

  for (let i = 0; i < tasks.value.length; i++) {
    const task=  new Task(tasks.value[i]);
    const ini = task.getIni();
    const fine = task.getFine();
    debugger
    minDates.push(new Date(task.getIni()).getTime());
    maxDates.push(new Date(task.getFine()).getTime());
  }
  minDate.value = new Date(Math.min.apply(null, minDates)).getTime();
  maxDate.value = new Date(Math.max.apply(null, maxDates)).getTime();

}

onMounted(() => {
  storeProject.loadProjects();
  //setMinAndMaxDate();
  //buildTableHeader.value = buildheaderMonth();

})

const monthdays = ref<IMonth[]>([]);

const buildTableHeader = ref<string[]>([])


const buildheaderMonth = () => {
  const html: string[] = []
  if (maxDate.value == undefined && minDate.value == undefined) {
    return html;
  }

  const diffDays = diffInDays(maxDate.value!, minDate.value!) + 1;
  const actual = new Date(minDate.value!);

  monthdays.value.push({ month: actual.getMonth(), ini: actual.getDate(), fine: actual.getDate() });
  html.push(actual.getDate().toString());
  for (let i = 0; i < diffDays; i++) {
    actual.setDate(actual.getDate() + 1);
    if (i + 1 < diffDays) {
      html.push(actual.getDate().toString());
    }

    if (monthdays.value.length > 0) {
      const index = monthdays.value.length - 1;
      if (monthdays.value[index].month == actual.getMonth()) {
        monthdays.value[index].fine = actual.getDate();
      } else {
        const initDay = new Date(actual.getFullYear(), actual.getMonth(), 1);
        monthdays.value[index + 1] = { month: actual.getMonth(), ini: initDay.getDate(), fine: actual.getDate() }
      }

    }
  }

  //console.log(monthdays.value);
  return html;
}

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

const buildTableBody = computed(() => {
  const items: { daysBefore: number, daysAfter: number, task: TaskInterface, days: number }[] = []

  for (let i = 0; i < tasks.value.length; i++) {
    const task = new Task(tasks.value[i]);
debugger
    const dMin = new Date(task.getIni()).getTime();
    const dMax = new Date(task.getFine()).getTime();

    var days = diffInDays(dMax, dMin) + 1;
    var daysBefore = diffInDays(minDate.value!, dMin);
    var daysAfter = diffInDays(dMax, maxDate.value!);

    if (minDate.value == dMin) daysBefore = 0;
    if (maxDate.value == dMax) daysAfter = 0;

    items.push({ daysBefore, daysAfter, task, days });

  }
  return items;

})


const diffInDays = (max: number, min: number) => {
  var diffTime = Math.abs(max - min);
  return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
}



const handlerSearchProject=(payload: string)=>{
  //storeProject.loadProjects({ name: { "$contains": `%${payload}%` } }/* { name: {$eq: newval } } */)
  storeProject.loadProjects({ name: payload })
}

const handlerNewProject=()=>{
  storeProject.setProject({name:''});
}

const handlerChangeProject=(payload: ProjectInterface)=>{
  storeProject.setProject(payload);
  storeProject.loadTasks().then(()=>{
    
    

  }).finally(()=>{
    rebuild();
  });
  //storeProject.loadProjects({ name: { "$contains": `%${payload}%` } }/* { name: {$eq: newval } } */)
}
const handlerSaveProject=(payload:ProjectInterface)=>{
  storeProject.saveProject(payload);
}

const handlerChangeModalTask= (payload:boolean)=>{
  showTask.value=payload
}

const handlerSaveTask =(payload: TaskInterface)=>{
  storeProject.saveTask(payload).then(res=>{
    
    rebuild();
  });
}


const rebuild=()=>{
    minDate.value=undefined;
    maxDate.value=undefined;
    monthdays.value=[];
    buildTableHeader.value=[];
    setMinAndMaxDate();
    buildTableHeader.value = buildheaderMonth();
}

const handlerNewTask=()=>{
  storeProject.createTask();
  showTask.value=true;
}

const handlerSelectTask = (task: TaskInterface) => {
  debugger
  storeProject.selectTask(task);
  showTask.value=true;
}
</script>

<style>
#gantt {
  font-family: "Roboto";
  width: 100vw;
  overflow-x: scroll;
  /* margin-left:5em;  */
  overflow-y: visible;
  padding-bottom: 1px;
}

#gantt table {
  border-collapse: collapse;
  border-spacing: 0px 20px;
}

table tr {
  border-bottom: 1px solid white;
}

#gantt table tr th {
  border: 1px solid white;
  border-collapse: collapse;
  font-size: 12px;
  /* background-color: lightgray; */
  line-height: 20px;
}

.stick {
  position: sticky;
}

#gantt table tr td {
  line-height: 25px;
  border-left: 1px dotted gray;
  width: 250px;
}

#gantt table tr td:last-child {
  border-right: 1px dotted gray;
}

#gantt table tr td.event-cell {
  color: white;
  font-size: 12px;
  text-align: left;
  border-left: none;
}

#gantt table tr td.event-cell:last-child {
  border-right: none;
}

#gantt table tr td.event-cell span {
  background-color: #f6a400;
  border-radius: 15px;
  color: #685c43;
}

/* .shrink {
    white-space:nowrap
} */
td,
th {
  margin: 0;
  border: 3px solid grey;
  border-top-width: 0px;
  white-space: nowrap;
}

tr>th:first-child,
tr>td:first-child {
  position: sticky;
  left: 0;
  /* background-color: white */
}

.headcol {
  position: absolute;

  left: 0;
  top: auto;
  border-right: 0px none black;
  border-top-width: 3px;

  margin-top: -3px;

}

.cell {
  min-width: 25px;
}


.cursor {
  cursor: pointer;
}
</style>
