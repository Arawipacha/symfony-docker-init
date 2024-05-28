import { ResultData } from "../interfaces/tauri/result.data.interface";
import { ResultInterface } from "../interfaces/tauri/result.interface";
import { Project } from "./project";

export class ResultProject implements ResultInterface<Project>{
    
    constructor(
        public result: ResultData<Project>,
        public error?: string,
    ){

    }

}