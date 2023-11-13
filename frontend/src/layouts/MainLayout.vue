<template>
  <q-layout view="lHh Lpr lff" class="shadow-2 rounded-borders">
    <q-header elevated class="bg-cyan-8">
      <navigation-menu>
        <template v-slot:menu-button>
          <q-btn flat @click="drawer = !drawer" round dense icon="menu" />
        </template>
      </navigation-menu>
    </q-header>

    <q-drawer v-model="drawer" show-if-above :width="256" :breakpoint="400">
      <q-scroll-area style="height: calc(100% - 150px); margin-top: 150px; border-right: 1px solid #ddd">
        <q-list padding>
          <q-item clickable v-ripple>
            <q-item-section avatar>
              <q-icon name="density_small" />
            </q-item-section>

            <q-item-section>
              <drawer-content>
                <template v-slot:posts-link>
                  <router-link :to="{ name: 'dashboard' }">
                    <a>Все посты</a>
                  </router-link>
                </template>
              </drawer-content>
            </q-item-section>
          </q-item>

          <q-item clickable v-ripple>
            <q-item-section avatar>
              <q-icon name="add_task" />
            </q-item-section>
            <q-item-section>
              <drawer-content>
                <template v-slot:my-posts-link>
                  <router-link :to="{ name: 'user-posts' }">
                    <a>Управление постами</a>
                  </router-link>
                </template>
              </drawer-content>
            </q-item-section>
          </q-item>

          <q-item clickable v-ripple>
            <q-item-section avatar>
              <q-icon name="settings" />
            </q-item-section>
            <q-item-section>
              <drawer-content>
                <template v-slot:my-posts-link>
                  <router-link :to="{ name: 'manage-accaunt' }">
                    <a>Управление аккаунтом</a>
                  </router-link>
                </template>
              </drawer-content>
            </q-item-section>
          </q-item>
        </q-list>
      </q-scroll-area>

      <q-img class="absolute-top" src="https://cdn.quasar.dev/img/material.png" style="height: 150px">
        <div class="absolute-bottom bg-transparent">
          <q-avatar size="56px" class="q-mb-sm">
            <img src="https://cdn.quasar.dev/img/boy-avatar.png" />
          </q-avatar>
          <!-- потом убрать как на сранице логина буудет дравер недоступен -->
          <div class="text-weight-bold">{{ userData ? userData.data.email : '' }}</div>
          <div>{{ userData ? userData.data.name : '' }}</div>
        </div>
      </q-img>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { ref, computed } from 'vue'
import DrawerContent from 'src/components/DrawerContent.vue'
import NavigationMenu from 'src/components/NavigationMenu.vue'
import { useStore } from 'vuex'

export default {
  name: 'MainLayout',
  components: {
    DrawerContent,
    NavigationMenu,
  },
  setup() {
    const store = useStore()

    const loadUser = () => {
      store.dispatch('user/fetchUser').catch((error) => {
        console.error('Ошибка при получении пользователя:', error)
      })
    }

    const userData = computed(() => store.getters['user/user'])

    loadUser()
    return {
      drawer: ref(false),
      userData,
    }
  },
}
</script>
