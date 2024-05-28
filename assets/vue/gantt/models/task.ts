import { TaskInterface } from "../interfaces/task.interface";

export  class Task implements TaskInterface {
    public project_id: string;
    public name: string;
    public ini: string;
    public fine: string;
    public color: string;
    public per: number;
    public id?: string;

    constructor(
        task:TaskInterface
    ) {
        this.project_id=task.project_id;
        this.name=task.name;
        this.ini=task.ini;
        this.fine=task.fine;
        this.color=task.color;
        this.per=task.per;
        this.id=task.id;
    }


    public getIni() {
        return this.ini.substring(0,10).replaceAll('-','/');
    }

    public getFine() {
        return this.fine.substring(0,10).replaceAll('-','/');
    } 


}

