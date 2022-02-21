<template>
  <l-map style="height:50vh"
    @click="addMarker"
    :center="[42.309410, 	9.149022]" 
    :zoom="12" 
  >
    <l-marker v-for="marker, index in markers" v-bind:key="marker.index" :lat-lng="marker.latLng"></l-marker>
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
      ]
    };
  },
  async beforeMount() {
    // HERE is where to load Leaflet components!
    const { circleMarker } = await import("leaflet/dist/leaflet-src.esm");

    // And now the Leaflet circleMarker function can be used by the options:
    this.geojsonOptions.pointToLayer = (feature, latLng) =>
      circleMarker(latLng, { radius: 8 });
    this.mapIsReady = true;
  },
  methods: {
    addMarker(e) {
      var id = this.uuidv4()
      console.log({id: id, latlng: e.latlng})
      if(e.latlng == undefined) {
        return
      }
      this.markers.push({id: id, latlng: e.latlng});
    },
    uuidv4() {
      return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
      )
    }
  }
};
</script>