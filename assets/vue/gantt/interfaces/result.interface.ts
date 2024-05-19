
import { ResultData } from "./result.data.interface";

export interface ResultInterface<T>{
    error?:string;
    result:ResultData<T>;
}