import type { users } from '@/types/users/index';
import { itiFormat } from '@/utils/itiFormat';

const users: users[] = [
    {
        id: 1,
        iti: itiFormat("10011122233"),
        name: "Max Ferreira",
        email: "max@gmail.com",
    },
    {
        id: 2,
        iti: itiFormat("10011122234"),
        name: "Nicholas Ferreira",
        email: "nicholas@gmail.com",
    },
];

export { users }