import type User from "./user";
import type Vault from "./vault";

export default interface History {
    id: number;
    user: User;
    vault: Vault;
    code: string;
    updatedAt: Date;
}