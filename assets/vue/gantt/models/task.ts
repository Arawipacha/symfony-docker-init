import { TaskInterface } from "../interfaces/task.interface";

export  class Task implements TaskInterface {


    constructor(
        public name: string,
        public dt_ini: string,
        public dt_fine: string,
        public color: string,
        public percent: number,
        public id?: string
    ) {
        
    }


}