
import { ResultsData } from "./results.data.interface";

export interface ResultsInterface<T>{
    error?:string;
    result:ResultsData<T>;
}