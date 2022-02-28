<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                KartoBuilder - Map
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                    <div class="flex flex-row w-full space-x-4">
                        <div class="flex w-1/2 space-x-2">
                            <input type="text" v-model="projectName" placeholder="Project name..."
                                class="items-center w-72 text-left space-x-3 px-4 h-12 bg-white ring-1 ring-gray-900/10 hover:ring-gray-300 focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-sm rounded-lg text-gray-400 dark:bg-gray-800 dark:ring-0 dark:text-gray-300 dark:highlight-white/5 dark:hover:bg-gray-700">
                            <button @click="createMap"
                                class="bg-gray-900 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-gray-50 text-white font-semibold h-12 px-6 rounded-lg w-full flex items-center justify-center sm:w-auto dark:bg-sky-500 dark:highlight-white/20 dark:hover:bg-sky-400">
                                Create
                            </button>
                        </div>
                        <div class="w-1/2">
                            <table class="border-collapse table-auto w-full text-sm">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            #</th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Name</th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-show="maps" v-for="map in maps" v-bind:key="map.id">
                                        <td
                                            class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm w-2/5">
                                            {{map.id}}</td>
                                        <td
                                            class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm w-2/5">
                                            {{map.name}}</td>
                                        <td
                                            class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm w-2/5">
                                            <a class="mr-2 text-green-500" :href="route('map.show', map.id)"><i class="far fa-2x fa-map-signs"></i></a>
                                            <a class="text-red-500 cursor-pointer	" @click="deleteElement(map.id)"><i class="fas fa-2x fa-times"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import { Inertia } from '@inertiajs/inertia'

export default {
  components: {
    AppLayout
  },
  data() {
    return {
      projectName: '',
    }
  },
  props: {
    maps: Array,
    currentRoute: String,
  },
  methods: {
    createMap() {
      Inertia.post(route('maps.store'), {
        name: this.projectName,
      })
    },
    deleteElement(id) {
      this.$inertia.delete(route('maps.destroy', id))
    },
  }
};
</script>