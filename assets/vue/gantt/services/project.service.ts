import axios from "axios";
import { Project } from "../models/project";
import { BaseFilter } from "../interfaces/tauri/project.filter.interface";
import { ProjectInterface } from "../interfaces/project.interface";
import { Result } from "../interfaces/result.interface";
import { TaskFilter } from "../interfaces/task.filter.interface";
import { Task } from "../models/task";
import { TaskInterface } from "../interfaces/task.interface";

export const requestProjects= async (filter?: BaseFilter)=>{    
    let params={ }
    if(filter) params={...filter}
    return await axios.get<Result<Project>>(`/api/projects`,{params}).then(({ data }) => {
        return data;
    });
}

export const fetchUpdateProject= async (payload: ProjectInterface)=>{
    return await axios.put<Project>(`/api/projects`, {...payload}).then(({ data }) => {
        return data;
    });
}

export const fetchCreateProject= async (payload: ProjectInterface)=>{
    return await axios.post<Project>(`/api/projects`, {...payload}).then(({ data }) => {
        return data;
    });
}



export const requestTasks= async (filter: TaskFilter)=>{    
    let params={ }
    if(filter) params={...filter}
    return await axios.get<Result<Task>>(`/api/project/${filter.project_id}/tasks`,{params}).then(({ data }) => {
        return data;
    });
}



export const fetchUpdateTask = async (payload: TaskInterface)=>{
    return await axios.put<Task>(`/api/project/${payload.project_id}/tasks`, {...payload}).then(({ data }) => {
        return data;
    });
}

export const fetchCreateTask= async (payload: TaskInterface)=>{
    return await axios.post<Task>(`/api/project/${payload.project_id}/tasks`, {...payload}).then(({ data }) => {
        return data;
    });
}