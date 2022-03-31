<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                KartoBuilder - Map builder
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                    <div class="flex flex-row space-x-3">
                        <div class="w-2/4">
                            <h1 class="text-3xl">Create</h1>
                            <div class="flex flex-row my-2 space-x-2">
                                <div class="flex space-x-2">
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                                        @click="this.phase = 1" v-if="this.phase === 0">
                                        Point
                                    </button>
                                    <button
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded"
                                        @click="this.phase = 0, markers = [], strokecolor = '#2A81CB'" v-if="this.phase === 1">
                                        Cancel
                                    </button>
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                                        @click="this.phase = 2" v-if="this.phase === 0">
                                        Aera
                                    </button>
                                    <button
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded"
                                        @click="this.phase = 0, polygon = [], strokecolor = '#2A81CB'" v-if="this.phase === 2">
                                        Cancel
                                    </button>
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                                        @click="this.phase = 3" v-if="this.phase === 0">
                                        Path
                                    </button>
                                    <button
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded"
                                        @click="this.phase = 0, polyline = [], strokecolor = '#2A81CB'" v-if="this.phase === 3">
                                        Cancel
                                    </button>
                                </div>
                                <div class="flex justify-end w-full">
                                    <input type="number" placeholder="Code postal" v-model="codePostal">
                                </div>
                            </div>
                            <table class="border-collapse table-fixed w-full text-sm">
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
                                    <tr v-for="element in listGeoJSON" v-show="listGeoJSON" v-bind:key="element.id">
                                        <td
                                            class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm w-2/5">
                                            {{element.id}}</td>
                                        <td
                                            class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm w-2/5">
                                            {{element.name}}</td>
                                        <td
                                            class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm w-2/5">
                                            <button class="text-red-500" @click="deleteElement(element.id)"><i
                                                    class="fas fa-2x fa-times"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div v-if="this.phase === 1" class="flex flex-row space-x-2 mt-2">
                                <button
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                                    @click="saveMarker">
                                    Create
                                </button>
                                <input type="text" v-model="name">
                            </div>
                            <div v-if="this.phase === 2" class="flex flex-row space-x-2 mt-2">
                                <button
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                                    @click="saveZone">
                                    Create
                                </button>
                                <input type="text" v-model="name">
                            </div>
                            <div v-if="this.phase === 3" class="flex flex-row space-x-2 mt-2">
                                <button
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                                    @click="savePath">
                                    Create
                                </button>
                                <input type="text" v-model="name">
                            </div>
                            <div v-if="this.phase === 2 || this.phase === 3" class="mt-2 border border-gray-300 rounded bg-gray-200 p-2 rounded w-1/4">
                              <div @click="SwitchColor('#2A81CB')" >Default Color</div>
                              <hr class="border-gray-600 mt-1 mb-2">
                              <div class="grid gap-2 grid-cols-3">
                                <span @click="SwitchColor('#e74c3c')" class="h-8 w-8 cursor-pointer	red"></span>
                                <span @click="SwitchColor('#8e44ad')" class="h-8 w-8 cursor-pointer	purple" ></span>
                                <span @click="SwitchColor('#5352ed')" class="h-8 w-8 cursor-pointer	blue" ></span>
                                <span @click="SwitchColor('#f1c40f')" class="h-8 w-8 cursor-pointer	yellow" ></span>
                                <span @click="SwitchColor('#e67e22')" class="h-8 w-8 cursor-pointer	orange" ></span>
                                <span @click="SwitchColor('#2c3e50')" class="h-8 w-8 cursor-pointer	black" ></span>
                                <span @click="SwitchColor('#27ae60')" class="h-8 w-8 cursor-pointer	green" ></span>
                              </div>
                            </div>
                        </div>
                        <div class="w-2/4">
                            <l-map style="height:50vh;width=25%" @click="addMarker($event)" :center="center" :zoom="14">
                                <l-marker v-for="marker, index in markers" v-show="markers" v-bind:key="index"
                                    :lat-lng="marker.latlng" @click="deleteMarker(index)"></l-marker>
                                <l-polygon :lat-lngs="polygon" v-if="render" :color="strokecolor" />
                                <l-polyline :lat-lngs="polyline" v-if="render" :color="strokecolor" />
                                <l-tile-layer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" layer-type="base"
                                    name="OpenStreetMap"></l-tile-layer>
                                <l-geo-json v-for="element in listGeoJSON" v-show="listGeoJSON" v-bind:key="element.id"
                                    :geojson="element.GeoJSON" :options="options"></l-geo-json>

                                <l-control class="flex space-x-2 items-center" position="bottomleft" v-if="phase !== 0">
                                    <button class="px-3 py-2 bg-white border-2" @click="undo(phase)">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                    <input class="h-8 w-20 py-1" type="number" placeholder="lat" v-model="lat">
                                    <input class="h-8 w-20 py-1" type="number" placeholder="lng" v-model="lng">
                                    <button class="px-3 py-2 bg-white border-2" @click="addByCoor(phase)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </l-control>
                                <l-control class="flex space-x-2 items-center" position="topright" v-if="phase === 0">
                                    <input class="h-8 w-20 py-1" type="number" placeholder="lat" v-model="latCenter">
                                    <input class="h-8 w-20 py-1" type="number" placeholder="lng" v-model="lngCenter">
                                    <input class="h-8 w-20 py-1" type="number" placeholder="zoom" v-model="zoom">
                                    <button class="px-3 py-2 bg-white border-2" @click="updateConfig()">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </l-control> 
                            </l-map>
                        </div>
                    </div>
                </div>
                <a class="text-gray-400" :href="route('maps.index')"><i class="fas fa-backward mr-2"></i>retour</a>
            </div>
        </div>
    </app-layout>
</template>

<script>
import Inertia from '@inertiajs/inertia'
import Axios from 'axios'
import "leaflet/dist/leaflet.css"
import { LMap, LTileLayer, LMarker, LGeoJson, LPolygon, LPolyline, LControl} from "@vue-leaflet/vue-leaflet";
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout'
import {ref} from 'vue'

export default {
  components: {
    LMap,
    LGeoJson,
    LTileLayer,
    LMarker,
    LPolygon,
    LPolyline,
    LControl,
    AppLayout
  },
  data() {
    return {
      zoom: 9,
      phase: 0,
      latCenter: null,
      lngCenter: null,
      center: null,
      markers: [],
      polygon: [],
      strokecolor: '#2A81CB',
      polyline: [],
      listGeoJSON: null,
      name: '',
      codePostal: '',
      render: false,
      lat: null,
      lng: null,
      options: {
        onEachFeature: function onEachFeature(feature, layer) {
          if(typeof layer.setStyle === 'function'){
          console.log(feature.properties)
          	layer.setStyle({color:feature.properties.stroke})
          }
        }
      }
    }
  },
  props: {
    map: Object,
    mapElement: Array,
    currentRoute: String,
    Defaultcenter: Array,
    Defaultzoom: Number,
  },
  mounted() {
     this.listGeoJSON = this.mapElement
     this.center = [this.latCenter, this.lngCenter]
     if(this.Defaultzoom !== null){
      this.zoom = this.Defaultzoom
     }
     if(this.Defaultcenter !== null){
      this.center = this.Defaultcenter
      this.latCenter = this.Defaultcenter[0]
      this.lngCenter = this.Defaultcenter[1]
     }else{
       this.center = [42.30941, 9.149022]
     }
  },
  computed: {
    center() {
      if(this.Defaultcenter !== null){
      this.center = this.Defaultcenter
      this.latCenter = this.Defaultcenter[0]
      this.lngCenter = this.Defaultcenter[1]
     }else{
       this.center = [42.30941, 9.149022]
     }
     return this.center
    },
  },
  setup() {
    let searchTerm = ref('')

    return {
      searchTerm
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
      if(this.phase === 2) {
        var id = this.uuidv4()
        if(event.latlng == undefined) {
          return
        }
        var lastZoneIndex = this.polygon.length - 1
        if(this.polygon[lastZoneIndex]) {
          if(this.polygon[lastZoneIndex][0] === event.latlng.lat && this.polygon[lastZoneIndex][1] === event.latlng.lng) {
            return
          }
        }
        this.render = false;
        this.polygon.push([event.latlng.lat, event.latlng.lng]);
        this.$nextTick(() => {
          this.render = true
        });
      }
      if(this.phase === 3) {
        var id = this.uuidv4()
        if(event.latlng == undefined) {
          return
        }
        var lastPathIndex = this.polyline.length - 1
        if(this.polyline[lastZoneIndex]) {
          if(this.polyline[lastZoneIndex][0] === event.latlng.lat && this.polyline[lastZoneIndex][1] === event.latlng.lng) {
            return
          }
        }
        this.render = false;
        this.polyline.push([event.latlng.lat, event.latlng.lng]);
        this.$nextTick(() => {
          this.render = true
        });
      }
    },
    deleteMarker(id) {
      this.markers.splice(id, 1)
    },
    SwitchColor(color) {
      this.strokecolor = color
    },
    saveMarker() {
      this.phase = 0
      var data = {
        markers: this.markers,
        name: this.name,
        map_id: this.map.id
      }
      this.name = ''
      this.markers = []
      this.strokecolor = '#2A81CB'
      this.$inertia.post(route('map.store'), data)
    },
    saveZone() {
      this.phase = 0
      var data = {
        polygon: this.polygon,
        name: this.name,
        properties: {
          stroke: this.strokecolor
        },
        map_id: this.map.id
      }
      this.polygon = []
      this.name = ''
      this.strokecolor = '#2A81CB'
      this.render = false
      this.$inertia.post(route('map.store'), data)
    },
    savePath() {
      this.phase = 0
      var data = {
        polyline: this.polyline,
        name: this.name,
        properties: {
          stroke: this.strokecolor
        },
        map_id: this.map.id
      }
      this.polyline = []
      this.name = ''
      this.strokecolor = '#2A81CB'
      this.render = false
      this.$inertia.post(route('map.store'), data)
    },
    updateConfig() {
      var data = {
        center: this.center,
        zoom: this.zoom
      }
      this.center = [this.latCenter, this.lngCenter]
      this.$inertia.put(route('config.map', this.map.id), data)
    },
    deleteElement(id) {
      this.$inertia.delete(route('map.destroy', id))
    },
    uuidv4() {
      return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
      )
    },
    undo(phase) {
      this.render = false;
      if(phase === 1) {
        this.markers.pop()
      }
      if(phase === 2) {
        this.polygon.pop()
      }
      if(phase === 3) {
        this.polyline.pop()
      }
      this.$nextTick(() => {
          this.render = true
      });
    },
    addByCoor(phase){
      this.render = false;
      if(phase === 1) {
        this.markers.push({id: this.uuidv4(), latlng: [this.lat, this.lng]});
      }
      if(phase === 2) {
        this.polygon.push([this.lat, this.lng]);
      }
      if(phase === 3) {
        this.polyline.push([this.lat, this.lng]);
      }
      this.$nextTick(() => {
          this.render = true
      });
    }
  },
  watch: {
    mapElement(newElement, oldElement){
      this.listGeoJSON = newElement
    },
    codePostal(newElement, oldElement){
      axios.get('https://geo.api.gouv.fr/communes?codePostal='+newElement+'&format=geojson')
      .then(response => {
        this.center = [response.data.features[0].geometry.coordinates[1], response.data.features[0].geometry.coordinates[0]]
        this.latCenter = response.data.features[0].geometry.coordinates[1]
        this.lngCenter = response.data.features[0].geometry.coordinates[0]
      })
    }
  }
};
</script>
<style>
 .red {
   background-color: #e74c3c;
 }
 .orange {
   background-color: #e67e22;
 }
 .yellow {
    background-color: #f1c40f;
 }
 .purple {
   background-color: #8e44ad;
 }
 .blue {
    background-color: #5352ed;
 }
 .green {
   background-color: #27ae60;
 }
 .black {
   background-color: #2c3e50;
 }
.inner-circle {
  position: absolute;
  border: 4px solid rgba(0, 0, 0, 0.0);
  border-radius: 100%;
  margin: 7px;
  transition: all 0.45s;
}
</style>