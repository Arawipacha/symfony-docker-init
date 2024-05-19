import { ResultsData } from "../interfaces/results.data.interface";
import { ResultsInterface } from "../interfaces/results.interface";
import { Project } from "./project";

export class ResultProjects implements ResultsInterface<Project>{
    
    constructor(
        public result: ResultsData<Project>,
        public error?: string,
    ){

    }

}