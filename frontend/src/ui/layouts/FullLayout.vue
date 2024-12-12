<template>
  <v-app>
    <Navigation />
    <v-main>
      <router-view />
    </v-main>
    <AppFooter />
  </v-app>
</template>

<script>
import Navigation from '@/ui/components/Navigation';
import AppFooter from '@/ui/components/AppFooter'
export default {
  name: 'FullLayout',
  components: {
    Navigation,
    AppFooter
  }
}
</script>