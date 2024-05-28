import { MetaInfinity } from "./meta";

export interface Result<T>{
    items: T[];
    meta: MetaInfinity;

}