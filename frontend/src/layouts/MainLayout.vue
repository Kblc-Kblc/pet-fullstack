<template>
  <q-layout view="hHh lpR fff">
    <q-header elevated class="bg-primary text-white" @click="drawerLeft = !drawerLeft">
      <nav-bar></nav-bar>
    </q-header>

    <q-drawer v-model="drawerLeft" show-if-above side="left" bordered>
      <!-- drawer content -->
      <drawer-content />
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>

    <q-footer reveal elevated class="bg-grey-8 text-white"> </q-footer>
  </q-layout>
</template>

<script>
import { ref } from 'vue'
import NavBar from 'src/components/NavigationMenu.vue'
import DrawerContent from 'src/components/DrawerContent.vue'

export default {
  components: {
    NavBar,
    DrawerContent,
  },
  setup() {
    const drawerLeft = ref(false)

    return {
      drawerLeft,
    }
  },
}
</script>
