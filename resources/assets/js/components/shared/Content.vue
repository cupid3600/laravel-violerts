<template>
    <div class="container">
        <div
            class="col-xl-6 offset-xl-3 col-lg-6 offset-lg-3 col-md-6 offset-md-3"
            id="main-content">
            <h1>
                Monitoring property <br>
                just got a lot easier.
            </h1>
            <br>
            <Search
                @error="onError"
            />
            <p
                class="error"
                v-if="error">{{ error }}</p>
        </div>
    </div>
</template>
<script scoped>
import Search from './Search.vue'
export default {
    data() {
        return {
            error: ''
        }
    },
    methods: {
        onError(error) {
            console.error('onError()', error)
            this.error = 'There was a problem processing your request.'
        }
    },
    components: {
        Search
    }
}
</script>
<style scoped>
    .error {
        margin: 5px;
        color: white;
        font-weight: 600;
    }

    /* main content styling */
    #main-content {
        text-align: center;
        padding-top: 30vh;
    }

    #main-content > h1 {
        color: #fff;
        font-weight: 300;
    }

    /* iphone 4/4s - portrait */
    @media only screen
      and (min-device-width: 320px)
      and (max-device-width: 480px)
      and (-webkit-min-device-pixel-ratio: 2)
      and (orientation: portrait) {
          #main-content h1 {
              font-size: 22px;
          }
    }

    /* iphone 5/5s/5c - portrait */
    @media only screen
    and (min-device-width: 320px) 
    and (max-device-width: 568px)
    and (-webkit-min-device-pixel-ratio: 2)
    and (orientation: portrait) {

    }

    /* iphone 6/7 - portrait */
    @media only screen
    and (min-device-width: 375px)
    and (max-device-width: 667px)
    and (-webkit-min-device-pixel-ratio: 2) {

    }

    /* iphone 6+/7+/8+ - portrait */
    @media only screen
    and (min-device-width: 414px)
    and (max-device-width: 736px)
    and (-webkit-min-device-pixel-ratio: 3)
    and (orientation: portrait) {
        #main-content h1 {
              font-size: 28px;
          }
    }

    /* iphone x - portrait */
    @media only screen
    and (min-device-width: 375px)
    and (max-device-width: 812px)
    and (-webkit-min-device-pixel-ratio: 3)
    and (orientation: portrait) {
        #main-content h1 {
              font-size: 28px;
          }
    }
</style>
