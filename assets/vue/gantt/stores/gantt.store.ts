import { defineStore } from "pinia"
import { TaskInterface } from "../interfaces/task.interface"
import { ProjectInterface } from "../interfaces/project.interface";
import { fetchProjectList, fetchSaveProject } from "../services/ipc.services";
import { ProjectFilter } from "../interfaces/project.filter.interface";

interface State {
    projects:ProjectInterface[],
    project?:ProjectInterface,
    tasks: TaskInterface[];
    select_task?: TaskInterface;
  }




  export const useGanttStore = defineStore('authUser', {
    state: (): State => ({
      projects: [],
      tasks:[],
    }),
    getters: {
      getTasks: (state) => state.tasks,
      getprojects: (state) => state.projects,
      getproject: (state) => state.project,
    },
    actions: {
      
      async loadProjects (filter?: ProjectFilter) {
        fetchProjectList(filter).then((res)=>{
          this.projects=res.result.data;
        })
      },
      setProject (payload: ProjectInterface) {
        this.project=payload;
      },
      saveProject(payload: ProjectInterface){
          fetchSaveProject(payload).then(res=>{
            debugger
            this.project=res.result.data;
          })
      },

      // mutations can now become actions, instead of `state` as first argument use `this`
      
      // easily reset state using `$reset`
      clearUser () {
        this.$reset()
      }
    }
  })