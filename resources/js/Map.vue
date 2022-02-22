<template>
  <l-map style="height:50vh"
    @click="addMarker($event)"
    :center="[42.309410, 	9.149022]" 
    :zoom="12" 
  >
    <l-marker v-for="marker, index in markers" v-bind:key="index" :lat-lng="marker.latlng" @click="deleteMarker(index)"></l-marker>
    <l-tile-layer
      url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
      layer-type="base"
      name="OpenStreetMap"
    ></l-tile-layer>
  </l-map>
</template>

<script>
// DON'T load Leaflet components here!
// Its CSS is needed though, if not imported elsewhere in your application.
import "leaflet/dist/leaflet.css"
import { LMap, LTileLayer, LMarker, LGeoJson} from "@vue-leaflet/vue-leaflet";

export default {
  components: {
    LMap,
    LGeoJson,
    LTileLayer,
    LMarker
  },
  data() {
    return {
      zoom: 2,
      coordinates: [50, 50],
      markers: [
        {"id":"59559085-d55f-4285-808d-b620dfa2c840","latlng":{"lat":42.33545334454516,"lng":9.166030883789064}}
      ]
    };
  },
  methods: {
    addMarker(event) {
      var id = this.uuidv4()
      if(event.latlng == undefined) {
        return
      }
      var lastMarkerIndex = this.markers.length - 1
      if(this.markers[lastMarkerIndex].latlng.lat === event.latlng.lat && this.markers[lastMarkerIndex].latlng.lng === event.latlng.lng) {
        return
      }
      this.markers.push({id: id, latlng: event.latlng});
    },
    deleteMarker(id) {
      this.markers.splice(id, 1)
    },
    uuidv4() {
      return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
      )
    }
  }
};
</script>