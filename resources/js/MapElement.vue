<template>
    <div class="flex flex-row">
        <div class="w-1/4">
          <h1 class="text-3xl">Create</h1>
          <div class="flex flex-row my-2 space-x-2">
            <button 
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
              @click="this.phase = 1"
              v-if="this.phase === 0"
            >
              Point
            </button>
            <button 
              class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded"
              @click="this.phase = 0"
              v-if="this.phase === 1"
            >
              Cancel
            </button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
              Aera
            </button>
          </div>
          <table class="border-collapse table-fixed w-full text-sm">
              <thead>
                  <tr>
                      <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                      <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                      <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Manage</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="element in listGeoJSON" v-show="listGeoJSON" v-bind:key="element.id">
                      <td class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm w-2/5">{{element.id}}</td>
                      <td class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm w-2/5">{{element.name}}</td>
                      <td class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm w-2/5"><button @click="deleteElement(element.id)">x</button></td>
                  </tr>
              </tbody>
          </table>
          <div v-show="this.phase === 1" class="flex flex-row space-x-2 mt-2">
              <button
                  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                  @click="saveMarker">
                  Create
              </button>
              <input type="text" v-model="name">
          </div>
          
        </div>
        <div class="w-2/4">
            <l-map style="height:50vh;width=25%" @click="addMarker($event)" :center="[42.309410, 	9.149022]" :zoom="14">
                <l-marker v-for="marker, index in markers" v-show="markers" v-bind:key="index" :lat-lng="marker.latlng"
                    @click="deleteMarker(index)"></l-marker>
                <l-polygon :lat-lngs="[
                  [42.29742106327276, 9.155280590057375],
                  [42.29681794674673, 9.154250621795656],
                  [42.29714331295855, 9.154062867164614],
                  [42.29745677393858, 9.153070449829103],
                  [42.298928829316885, 9.151954650878908],
                  [42.299849342416074, 9.151268005371096],
                  [42.300896806470526, 9.151096343994142],
                  [42.30102377062638, 9.152340888977053],
                  [42.30069048917119, 9.153628349304201],
                  [42.299531925626056, 9.1546368598938],
                  [42.29899231341091, 9.153628349304201],
                ]" color="#41b782" :fill="true" :fillOpacity="0.5" fillColor="#41b782" />
                <l-tile-layer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" layer-type="base"
                    name="OpenStreetMap"></l-tile-layer>
                <l-geo-json v-for="element in listGeoJSON" v-show="listGeoJSON" v-bind:key="element.id" :geojson="element.GeoJSON"></l-geo-json>
            </l-map>
        </div>
        <div class="w-1/4">
          <h1 class="text-3xl">KartoBuilder</h1>
        </div>
    </div>
</template>

<script>
import Inertia from '@inertiajs/inertia'
import Axios from 'axios'
import "leaflet/dist/leaflet.css"
import { LMap, LTileLayer, LMarker, LGeoJson, LPolygon} from "@vue-leaflet/vue-leaflet";
import axios from 'axios';

export default {
  components: {
    LMap,
    LGeoJson,
    LTileLayer,
    LMarker,
    LPolygon
  },
  data() {
    return {
      zoom: 2,
      phase: 0,
      markers: [],
      listGeoJSON: null,
      name: '',
    }
  },
  props: {
    map: Object,
    mapElement: Array
  },
  mounted() {
     this.listGeoJSON = this.mapElement
  },
  methods: {
    addMarker(event) {
      if(this.phase === 0) {
        return
      }
      if(this.phase === 1) {
        var id = this.uuidv4()
        if(event.latlng == undefined) {
          return
        }
        var lastMarkerIndex = this.markers.length - 1
        if(this.markers[lastMarkerIndex]) {
          if(this.markers[lastMarkerIndex].latlng.lat === event.latlng.lat && this.markers[lastMarkerIndex].latlng.lng === event.latlng.lng) {
            return
          }
        }
        this.markers.push({id: id, latlng: event.latlng});
      }
    },
    deleteMarker(id) {
      this.markers.splice(id, 1)
    },
    saveMarker() {
      this.phase = 0
      var data = {
        markers: this.markers,
        name: this.name,
        map_id: this.map.id
      }
      console.log(data)
      this.$inertia.post("/map", data)
    },
    deleteElement(id) {
      this.$inertia.delete("/map/" + id)
    },
    uuidv4() {
      return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
      )
    }
  },
  watch: {
    mapElement(newElement, oldElement){
      this.listGeoJSON = newElement
    }
  }
};
</script>