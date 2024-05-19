import { ProjectInterface } from "../interfaces/project.interface";

export class Project implements ProjectInterface{
    
constructor(
    
    public name: string,
    public id?: number | undefined,
){

    }
}