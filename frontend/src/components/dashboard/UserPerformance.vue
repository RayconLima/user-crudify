<script setup lang="ts">
import {users} from '@/data/users/usersData';
</script>
<template>
    <v-card elevation="10" class="">
        <v-card-item class="pa-6">
        <v-card-title class="text-h5 pt-sm-2 pb-7">Users</v-card-title>
        <v-table class="month-table">
            <thead>
                <tr>
                    <th class="text-subtitle-1 font-weight-bold">Id</th>
                    <th class="text-subtitle-1 font-weight-bold">Name</th>
                    <th class="text-subtitle-1 font-weight-bold">ITI</th>
                    <th class="text-subtitle-1 font-weight-bold">Email</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in users" :key="item.id" class="month-item">
                    <td>
                        <p class="text-15 font-weight-medium">{{ item.id }}</p>
                    </td>
                    <td>
                        <div class="">
                            <h6 class="text-subtitle-1 font-weight-bold">{{ item.name }}</h6>
                        </div>
                    </td>
                    <td>
                        <h6 class="text-body-1 font-weight-bold">{{ item.iti }}</h6>
                    </td>
                    <td>
                        <h6 class="text-body-1 font-weight-bold">{{ item.email }}</h6>
                    </td>
                </tr>
            </tbody>
        </v-table>
        </v-card-item>
    </v-card>
</template>
