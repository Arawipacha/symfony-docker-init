import { defineStore } from "pinia"
import { TaskInterface } from "../interfaces/task.interface"
import { ProjectInterface } from "../interfaces/project.interface";

import { BaseFilter } from "../interfaces/tauri/project.filter.interface";
import { requestProjects, fetchUpdateProject, fetchCreateProject, requestTasks, fetchUpdateTask, fetchCreateTask } from "../services/project.service";
import { TaskFilter } from "../interfaces/task.filter.interface";
import { useToast } from "./../../Pugins/Toast";

interface State {
    projects:ProjectInterface[],
    project?:ProjectInterface,
    //tasks: TaskInterface[];
    select_task?: TaskInterface;
    loading:boolean;
  }



  const stateToast = useToast();
  export const useGanttStore = defineStore('authUser', {
    state: (): State => ({
      projects: [],
      loading:false,
      //tasks:[],
    }),
    getters: {
      getTasks: (state) => state.project?.tasks ?? [],
      getTask: (state) => state.select_task,
      getprojects: (state) => state.projects,
      getproject: (state) => state.project,
      getLoading: (state) => state.loading,
      
    },
    actions: {
      
      async loadProjects (filter?: BaseFilter) {
        requestProjects(filter).then((res)=>{
          
          this.projects=res.items;
        })
      },
      async loadTasks (filter?: TaskFilter) {
        this.loading=true;
        if(filter && this.project && this.project.id){
          filter.project_id = this.project.id;
        }else if(this.project && this.project.id){
          filter = {project_id:this.project.id}
        }

        if(filter){
          await  requestTasks(filter).then((res)=>{
            if(this.project){
              this.loading=false;
              this.project.tasks=res.items;
            }
          })
        }
      },
      setProject (payload: ProjectInterface) {
        this.project=payload;
      },
      async saveProject(payload: ProjectInterface){
        if(payload.id){
          await fetchUpdateProject(payload).then(res=>{
            this.project={...this.project,...res};
            stateToast.success("Dati aggiornati");
          });
        }else{
          await fetchCreateProject(payload).then(res=>{
            this.project=res;
            stateToast.success("Dati salvati");
          });
        }
      },

      async saveTask(payload:TaskInterface){
        if(payload.id){
          await fetchUpdateTask(payload).then(res=>{
            const index =this.project!.tasks!.findIndex(i=>i.id==res.id);
            if(index>-1){
              this.select_task={...this.select_task,...res};
              this.project!.tasks![index]=this.select_task;
            }
            
            stateToast.success("Dati aggiornati");
          });
        }else{
          await fetchCreateTask(payload).then(res=>{
            this.select_task={...this.select_task,...res};
            this.project!.tasks!.push(this.select_task);
            
            stateToast.success("Dati salvati");
          });
        }
      },
      createTask(){
        
        if(this.project && this.project.id!=undefined){
          this.select_task={
            project_id:this.project.id,
            name:'',
            ini: new Date().toISOString().slice(0, 16),
            fine: new Date().toISOString().slice(0, 16),
            color: "#ffeeef",
            per:0
          }
        }
        
      },
      selectTask(payload: TaskInterface){
        this.select_task=payload;
      },
      // mutations can now become actions, instead of `state` as first argument use `this`
      
      // easily reset state using `$reset`
      clearUser () {
        this.$reset()
      }
    }
  })