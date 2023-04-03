<template>
    <v-app>
        <v-row>
            <v-col cols="12" md="4" sm="12">
                <airport-component></airport-component>
            </v-col>
            <v-col cols="12" md="4" sm="12">
                <airline-component></airline-component>
            </v-col>
            <v-col cols="12" md="4" sm="12">
                <flight-component></flight-component>
            </v-col>
        </v-row>
    </v-app>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>