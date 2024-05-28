import { Task } from "@/gantt/models/task";
import { TaskInterface } from "./task.interface";

export interface ProjectInterface{
    id?: string;
    name: string;
    tasks?: TaskInterface[];
}