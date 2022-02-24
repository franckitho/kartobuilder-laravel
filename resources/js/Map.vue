<template>
    <div class="flex flex-row">
        <div class="w-1/4">
          <h1 class="text-3xl">Create</h1>
          <div class="flex flex-row my-2 space-x-2">
            <button 
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
              @click="this.phase = 1"
            >
              Point
            </button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
              Aera
            </button>
          </div>
          <table class="border-collapse table-fixed w-full text-sm">
              <thead>
                  <tr>
                      <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                      <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                      <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Manage</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm w-2/5">1</td>
                      <td class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm w-2/5">Aera</td>
                      <td class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm w-2/5">OO</td>
                  </tr>
              </tbody>
          </table>
          <div>
              <button
                  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                  v-show="this.phase === 1"
                  @click="saveMarker">
                  Create
              </button>
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
                <l-geo-json :geojson="GeoMarkers"></l-geo-json>
            </l-map>
        </div>
        <div class="w-1/4">
          <h1 class="text-3xl">KartoBuilder</h1>
        </div>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
import "leaflet/dist/leaflet.css"
import { LMap, LTileLayer, LMarker, LGeoJson, LPolygon} from "@vue-leaflet/vue-leaflet";

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
      markers: []
    }
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
        markers: this.markers
      }
      console.log(data)
      this.$inertia.post("/map", data)
    },
    uuidv4() {
      return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
      )
    }
  }
};
</script>