import { ResultData } from "../interfaces/result.data.interface";
import { ResultInterface } from "../interfaces/result.interface";
import { Project } from "./project";

export class ResultProject implements ResultInterface<Project>{
    
    constructor(
        public result: ResultData<Project>,
        public error?: string,
    ){

    }

}