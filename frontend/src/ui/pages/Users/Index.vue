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

        <v-card-title>
          <v-btn @click="isDialogOpen = true" variant="tonal" size="small" :ripple="false">Adicionar usuário</v-btn>

          <v-dialog
            v-model="isDialogOpen"
            width="600px"
          >
            <v-card>
              <v-card-title>Adicionar usuário</v-card-title>

              <v-card-text>
                <v-row>
                  <v-col>
                    <v-text-field label="Nome"></v-text-field>
                  </v-col>

                  <v-col>
                    <v-text-field
                      label="Email"
                      :rules="emailRules"
                    ></v-text-field>
                  </v-col>
                </v-row>

                <v-select
                  label="Cargo"
                  :items="['Admin', 'Gerente', 'Convidado']"
                >
                </v-select>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="isDialogOpen = false">Cancelar</v-btn>
                <v-btn variant="tonal" color="success">Salvar</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-card-title>
      </div>

      <v-table>
        <thead>
          <tr>
            <th>#</th>
            <th>Nome</th>
            <th>C.P.F</th>
            <th>Email</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user?.id">
            <td>{{ user.id }}</td>
            <td>{{ user.name }}</td>
            <td>{{ formatITI(user.iti) }}</td>
            <td>{{ user.email }}</td>
            <td>
              <v-dialog width="600px">
                <template #activator="{ props }">
                  <v-btn v-bind="props" variant="tonal" color="primary">Editar</v-btn>
                </template>

                <v-card>
                  <v-card-text>
                    Editar
                  </v-card-text>
                </v-card>
              </v-dialog>
            </td>
          </tr>
        </tbody>
      </v-table>
    </v-card>
  </v-container>
</template>
<script setup>
  import { ref, onMounted, computed } from 'vue'
  import { useUsersStore } from "@/stores/users"
  import { formatITI } from '@/utils/masks';
  const users = computed(() => useUsersStore().users);

  onMounted(() => {
    useUsersStore().getUsers();
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
</script>