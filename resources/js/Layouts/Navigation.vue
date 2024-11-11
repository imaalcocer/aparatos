<template>
  <aside class="z-20 hidden w-64 overflow-y-auto bg-black md:block flex-shrink-0">
    <div class="py-4 text-white">
      <Link class="ml-6 text-lg font-bold text-gray-100" :href="route('dashboard')">
        Electronica
      </Link>

      <ul class="mt-6">
        <li class="relative px-6 py-3">
          <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
            <template #icon>
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                   stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
            </template>
            Dashboard
          </NavLink>
        </li>

        <li class="relative px-6 py-3">
          <NavLink :href="route('users.index')" :active="route().current('users.index')">
            <template #icon>
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                   xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
              </svg>
            </template>
            Users
          </NavLink>
        </li>

        <li class="relative px-6 py-3">
          <NavLink :href="route('marcas.index')" :active="route().current('marcas.index')">
            <template #icon>
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
     stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
    <path d="M5.5 2A2.5 2.5 0 003 4.5v7.879a2.5 2.5 0 00.732 1.768l7.879 7.879a2.5 2.5 0 003.536 0l7.879-7.879a2.5 2.5 0 000-3.536l-7.879-7.879A2.5 2.5 0 0012.379 2H5.5zM7 7a1.5 1.5 0 100 3 1.5 1.5 0 000-3z"></path>
</svg>

            </template>
            Marcas
          </NavLink>
        </li>

        <li class="relative px-6 py-3">
          <button @click="showingTwoLevelMenu = !showingTwoLevelMenu"
              class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800"
              aria-haspopup="true">
                <span class="inline-flex items-center">
                  <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
     stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
    <rect x="7" y="2" width="10" height="20" rx="2" ry="2"></rect>
    <path d="M11 18h2"></path>
</svg>
                    <span class="ml-4">Productos</span>
                </span>
            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
          </button>
            <ul v-show="showingTwoLevelMenu || route().current('productos.index')|| route().current('productos.create')" class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50"
                aria-label="submenu">
              <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800">
                <NavLink :href="route('productos.index')" :active="route().current('productos.index')">
                  Lista
                </NavLink>
              </li>
              <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800">
                <NavLink :href="route('productos.create')" :active="route().current('productos.create')">
                  Crear
                </NavLink>
              </li>
            </ul>
        </li>
      </ul>
    </div>
  </aside>
</template>

<script>
import NavLink from '@/Components/NavLink.vue'
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue'

export default {
  components: {
    NavLink,
    Link,
  },

  setup() {
    let showingTwoLevelMenu = ref(false)

    return {
      showingTwoLevelMenu
    }
  },
}
</script>
