<template>
  <v-container>
    <v-breadcrumbs :items="items">
      <template v-slot:prepend>
        <v-icon icon="$vuetify" size="small"></v-icon>
      </template>
    </v-breadcrumbs>

    <v-card flat class="border mb-4">
      <div class="d-flex justify-space-between">
        <v-card-title></v-card-title>

        <AddUser :isDialogOpen="isDialogOpen" />
      </div>

      <v-table>
        <thead>
          <tr>
            <th>#</th>
            <th>Nome</th>
            <th>C.P.F</th>
            <th>Email</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user?.id">
            <td>{{ user.id }}</td>
            <td>{{ user.name }}</td>
            <td>{{ formatITI(user.iti) }}</td>
            <td>{{ user.email }}</td>
            <td>{{ getStatus(user.status) }}</td>
            <td>
              <v-row>
                <ShowUser :user="user" />
                <EditUser :user="user" />
                <v-card-title>
                  <v-btn variant="tonal" color="red" size="small" :ripple="false" @click="destroyUser(user.id)">
                    Excluir
                  </v-btn>
                </v-card-title>
              </v-row>
            </td>
          </tr>
        </tbody>
      </v-table>
    </v-card>
  </v-container>
</template>
<script setup>
import { notify } from '@kyvg/vue3-notification'
import { ref, onMounted, computed } from 'vue'
import { useUsersStore } from '@/stores/users'
import { getStatus } from '@/utils/status'
import { formatITI } from '@/utils/masks'
import ShowUser from './Show.vue'
import AddUser from './Create.vue'
import EditUser from './Edit.vue'

const users = computed(() => useUsersStore().users)
const userStore = useUsersStore()
onMounted(() => {
  useUsersStore().getUsers()
})

const isDialogOpen = ref(false)
const items = ref([
  {
    title: 'Dashboard',
    disabled: false,
    to: { name: 'dashboard' },
  },
  {
    title: 'Usuários',
    disabled: false,
    to: { name: 'users' },
  },
])

const destroyUser = async (id) => {
  try {
    await userStore.destroyUser(id)
    notify({
      title: 'Deu certo!',
      type: 'success',
    })
    router.push({ name: 'users' })
  } catch (e) {
    notify({
      title: 'Falha ao autenticar',
      text: 'Falha na requisição',
      type: 'warn',
    })
  }
}
</script>
